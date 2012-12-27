<?php

namespace EcomDev\Test\Util;

class FileSystem
{
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
}