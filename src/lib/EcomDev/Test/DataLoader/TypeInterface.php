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

namespace EcomDev\Test\DataLoader;

/**
 * Interface for data type implementation
 *
 */
interface TypeInterface
{
    /**
     * Indicator of load file availability
     *
     * @param string $fileName
     * @return bool
     */
    public function isAvailable($fileName);

    /**
     * Loads file content and returns it as an array
     *
     * @param string $fileName
     * @return array
     */
    public function load($fileName);
}
