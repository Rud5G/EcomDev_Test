<?php
/**
 * Test Framework for Magento for Integration with various test solutions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   EcomDev
 * @package    EcomDev\Test
 * @copyright  Copyright (c) 2012 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */
namespace EcomDev\Test\Container;

/**
 * Abstract container implementation
 *
 * Containers are used for storing system information,
 * that later on can be evaluated by test framework
 */
abstract class ContainerAbstract implements ContainerInterface
{
    /**
     * Source for container
     *
     * @var mixed
     */
    protected $source = null;

    /**
     * Indexed data container
     *
     * @var array
     */
    protected $index = array();

    /**
     * Array of indexers organized by code
     *
     * @var array
     */
    protected $indexers = array();

    /**
     * Current find condition for matcher
     *
     * @var string
     */
    protected $currentCondition = null;

    /**
     * Sets source for container method
     *
     * @param mixed $source
     * @return ContainerAbstract
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Returns source that was set by setSource() method
     *
     * @return mixed
     */
    public function getSource()
    {
        if ($this->source === null) {
            $this->initSource();
        }

        return $this->source;
    }

    /**
     * Adds indexer to container
     *
     * @param string $code
     * @param callable $indexerCallback
     * @return ContainerAbstract
     */
    public function addIndexer($code, $indexerCallback)
    {
        if (is_callable($indexerCallback)) {
            $this->indexers[$code] = $indexerCallback;
        }

        return $this;
    }

    /**
     * Removes indexer from container by code
     *
     * @param string $code
     * @return ContainerAbstract
     */
    public function removeIndexer($code)
    {
        if (isset($this->indexers[$code])) {
            unset($this->indexers[$code]);
        }

        return $this;
    }

    /**
     * Indexes source by indexers
     *
     * @return ContainerAbstract
     */
    public function index()
    {
        $this->index = array();
        foreach ($this->indexers as $indexer) {
            if (is_string($indexer) || is_array($indexer)) {
                $indexerResult = call_user_func($indexer, $this->getSource(), $this);
            } else {
                $indexerResult = $indexer($this->getSource(), $this);
            }

            $this->index = array_merge_recursive($this->index, $indexerResult);
        }

        return $this;
    }

    /**
     * Return index data that was created from source objects by indexers
     *
     * @return array
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Finds data by search path in index
     *
     * Search path might look like the following:
     *
     * key1/key2/attribute=value/key3/key4
     * or
     * key1/key2/attribute=value&&attribute2=value/key3/key4
     * or
     * key1/key2/attribute!=value/key3/key4
     *
     * Supported operators for conditions match:
     * =  - equals
     * != - not equals
     * ~  - contains, for string or array
     * >  - more than
     * <  - less than
     * >= - more than equals
     * <= - less than equals
     * && - and
     * || - or
     *
     * @param string $path
     *
     * @return array|bool
     */
    public function find($path)
    {
        $path = explode('/', $path);
        $result = $this->getIndex();
        $ignorePath = false;
        while (!empty($path) && is_array($result)) {
            $currentPath = array_shift($path);
            if ($currentPath === '*') {
                $ignorePath = true;
            } elseif ($this->isCondition($currentPath)) {
                $this->currentCondition = $currentPath;
                $result = array_filter($result, array($this, 'matchCondition'));

                if (empty($result)) {
                    return false; // Return false if no sub items found
                }

                if (!empty($path)) { // Remove keys if it requires the next stage match
                    $ignorePath = true;
                }
            } elseif (!$ignorePath && isset($result[$currentPath])) {
                $result = $result[$currentPath];
            } elseif ($ignorePath) {
                $newResult = array();
                foreach ($result as $index => $item) {
                    if (isset($item[$currentPath])) {
                        $newResult[$index] = $item[$currentPath];
                    }
                }

                if (empty($newResult)) {
                    return false;
                }

                $result = $newResult;
                $ignorePath = false;
            } else {
                return false;
            }
        }

        if (!is_array($result)) {
            $result = array($result);
        }

        return $result;
    }

    /**
     * Is path condition check for operator match
     *
     * @param string $path
     * @return bool
     */
    protected function isCondition($path)
    {
        return !preg_match('/^[a-zA-Z0-9_]+$/', $path);
    }

    /**
     * Returns true or false based on condition match for an item
     *
     * @param array       $item
     * @param string|null $currentCondition
     * @return bool
     */
    protected function matchCondition($item, $currentCondition = null)
    {
        if ($currentCondition === null) {
            $currentCondition = $this->currentCondition;
        }

        if (!is_array($item) || $currentCondition === '' || $currentCondition === null) {
            return false;
        }

        if (strpos($currentCondition, '&&') !== false) {
            foreach (explode('&&', $currentCondition) as $subCondition) {
                if (!$this->matchCondition($item, $subCondition)) {
                    return false;
                }
            }

            return true;
        }

        if (strpos($currentCondition, '||') !== false) {
            foreach (explode('||', $currentCondition) as $subCondition) {
                if ($this->matchCondition($item, $subCondition)) {
                    return true;
                }
            }

            return false;
        }

        if (preg_match('/^([a-zA-Z0-9_]*)([\\!\\=\\~\\>\\<]{1,3})(.+)$/', $currentCondition, $matches)) {
            $field = $matches[1];
            $operator = $matches[2];
            $value = $matches[3];
        } else {
            $field = $currentCondition;
            $operator = '=';
            $value = true;
        }

        if (!isset($item[$field])) {
            return false;
        }

        $expectedResult = true;

        if (substr($operator, 0, 1) === '!') {
            $expectedResult = false;
            $operator = substr($operator, 1);
        }

        switch ($operator) {
            case '~':
                if (is_array($item[$field])) {
                    $result = in_array($value, $item[$field]);
                } else {
                    $result = strpos($item[$field], $value) !== false;
                }
                break;
            case '>':
                $result = $item[$field] > $value;
                break;
            case '<':
                $result = $item[$field] < $value;
                break;
            case '>=':
                $result = $item[$field] >= $value;
                break;
            case '<=':
                $result = $item[$field] <= $value;
                break;
            case '=':
            default:
                $result = $item[$field] == $value;
                // break; is not placed here for code coverage.
        }

        return $result === $expectedResult;
    }

    /**
     * Initializes source if it was not initialized
     *
     * @return ContainerAbstract
     */
    abstract protected function initSource();
}
