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

interface ContainerInterface
{
    /**
     * Sets source for container method
     *
     * @param $source
     * @return mixed
     */
    public function setSource($source);

    /**
     * Returns source that was set by setSource() method
     *
     * @return mixed
     */
    public function getSource();

    /**
     * This method returns internal index
     * based on source data
     *
     * @return array index array of container
     */
    public function getIndex();

    /**
     * Finds data by search path in index
     *
     * Search path might look like the following:
     *
     * key1/key2/@attribute=value/key3/key4
     * or
     * key1/key2/attribute=value/key3/key4
     * or
     * key1/key2/attribute!=value/key3/key4
     *
     * @param string $path
     * @return mixed|bool
     */
    public function find($path);

    /**
     * Adds indexer to container
     *
     * @param string $code
     * @param IndexerInterface $indexer
     *
     * @return mixed
     */
    public function addIndexer($code, IndexerInterface $indexer);

    /**
     * Removes indexer from container
     *
     * @param $code
     * @return mixed
     */
    public function removeIndexer($code);

    /**
     * Indexes data from source
     *
     * @return ContainerInterface
     */
    public function index();
}
