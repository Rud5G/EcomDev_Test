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

use Symfony\Component\Yaml\Yaml;

/**
 * PHP File Loader
 */
class TypePhp extends TypeAbstract
{
    /**
     * Checks that file is a PHP one
     *
     * @param string $fileName
     * @return bool
     */
    protected function isType($fileName)
    {
        $baseName = basename($fileName);
        return substr($baseName, -4) === '.php';
    }

    /**
     * Guess possible file name by provided basename,
     * if is without extension
     *
     * @param string $fileName
     * @return bool|string
     */
    protected function guessFileName($fileName)
    {
        $baseName = basename($fileName);
        $path = substr($fileName, 0, -strlen($baseName));
        if (strpos($baseName, '.') === false) {
            if (file_exists($path . '_' . $baseName . '.php')) {
                return $path . '_' . $baseName . '.php';
            }
        }

        return false;
    }

    /**
     * Parse PHP file and return array
     *
     * @param string $fileName
     * @return array|bool
     */
    public function load($fileName)
    {
        if (!$this->isType($fileName)) {
            $fileName = $this->guessFileName($fileName);
        }

        if ($fileName && file_exists($fileName)) {
            return include $fileName;
        }

        return false;
    }
}