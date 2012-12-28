<?php

namespace EcomDev\Test\Util;

/**
 * Magento Application Utility
 */
class App
{
    const DEFAULT_MAGE_CLASS = '\\Mage';

    protected static $mageClass = self::DEFAULT_MAGE_CLASS;

    protected static $replacedKeys = array();
    protected static $replacedRegistry = array();

    public static function isAvailable()
    {
        return class_exists(self::$mageClass, false);
    }
}