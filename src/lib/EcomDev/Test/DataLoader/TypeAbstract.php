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

abstract class TypeAbstract implements TypeInterface
{
    /**
     * Check if file name contains expected file extension
     *
     * @param $fileName
     * @return bool
     */
    abstract protected function isType($fileName);

    /**
     * Guess file name by interaction with file system
     *
     * @param $fileName
     * @return string|bool
     */
    abstract protected function guessFileName($fileName);

    /**
     * Indicator of load file availability
     *
     * @param string $fileName
     * @return bool
     */
    public function isAvailable($fileName)
    {
        if ($this->isType($fileName)) {
            return true;
        } elseif ($this->guessFileName($fileName) !== false) {
            return true;
        }

        return false;
    }
}