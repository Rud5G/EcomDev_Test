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

namespace EcomDev\Test\Container\Indexer;

use EcomDev\Test\Container\ContainerInterface;

/**
 * Abstract indexer class that is used for indexing data
 */
abstract class IndexerAbstract
{
    /**
     * Source from which container can be filled in
     *
     * @var mixed
     */
    protected $source;

    /**
     * Container for which index should be created
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Abstract indexer implementation
     *
     * @param string             $source
     * @param ContainerInterface $container
     * @return array
     */
    public function __invoke($source, ContainerInterface $container)
    {
        $this->setSource($source);
        $this->setContainer($container);

        $result = $this->index();
        return is_array($result) ? $result : array();
    }

    /**
     * Indexer implementation
     *
     * @return array
     */
    abstract public function index();

    /**
     * Set source property
     *
     * @param mixed $source
     * @return IndexerAbstract
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Retrieves source property
     *
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets container property
     *
     * @param ContainerInterface $container
     * @return IndexerAbstract
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Returns container property
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
