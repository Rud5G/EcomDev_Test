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
     * @return array
     */
    public function getIndex()
    {
        return $this->index;
    }
}