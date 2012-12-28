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

namespace EcomDev\Test\Util;

class FileSystem
{
    const MODULE_PATH = 'app/code/%s/%s';

    /**
     * Base path to Magento instance
     *
     * @var string
     */
    protected static $basePath = null;

    /**
     * Sets file system base path for tested Magento instance
     *
     * @param string $basePath
     * @throws \InvalidArgumentException
     */
    public static function setBasePath($basePath)
    {
        if (!file_exists($basePath . '/app/Mage.php')) {
            throw new \InvalidArgumentException(
                'Base path, that was provided, is not a Magento instance path'
            );
        }

        self::$basePath = $basePath;
    }

    /**
     * Returns file system base path within tested Magento instance
     *
     * @return string
     * @throws \RuntimeException
     */
    public static function getBasePath()
    {
        if (self::$basePath === null) {
            throw new \RuntimeException('Please specify Magento base path before using this utility');
        }

        return self::$basePath;
    }

    /**
     * Returns a directory iterator instance of module directory
     *
     * @param string $moduleName
     * @param string $codePool
     *
     * @return bool|\DirectoryIterator
     */
    public static function getModuleDirectory($moduleName, $codePool = null)
    {
        if ($codePool === null) {
            $codePool = 'core';
        }

        $modulePath = self::getBasePath() . '/' . sprintf(self::MODULE_PATH, $codePool, strtr($moduleName, '_', '/'));

        if (is_dir($modulePath)) {
            return new \DirectoryIterator($modulePath);
        }

        return false;
    }
}
