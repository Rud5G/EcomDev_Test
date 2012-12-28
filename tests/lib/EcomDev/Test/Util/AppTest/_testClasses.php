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
 * @package    EcomDev_Test
 * @copyright  Copyright (c) 2012 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */

namespace EcomDev\Test\Util\App;

/**
 * Test Mock for AppTest
 *
 */
final class MageTest
{
    /**
     * Registry collection
     *
     * @var array
     */
    static private $_registry = array();

    /**
     * Application model
     *
     * @var \Mage_Core_Model_App
     */
    static private $_app;

    /**
     * Config Model
     *
     * @var \Mage_Core_Model_Config
     */
    static private $_config;

    /**
     * Event Collection Object
     *
     * @var \Varien_Event_Collection
     */
    static private $_events;

    /**
     * Object cache instance
     *
     * @var \Varien_Object_Cache
     */
    static private $_objects;
}
