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
 * Data file loader factory
 *
 */
class TypeFactory
{
    /**
     * Available type loaders
     *
     * @var array
     */
    protected static $types = array();

    /**
     * Adds type loader
     *
     * @param TypeInterface $type
     * @return void
     */
    public static function add(TypeInterface $type)
    {
        if (!in_array($type, self::$types, true)) {
            self::$types[] = $type;
        }
    }

    /**
     * Removes type loader
     *
     * @param TypeInterface $type
     * @return void
     */
    public static function remove(TypeInterface $type)
    {
        if (in_array($type, self::$types, true)) {
            unset(self::$types[array_search($type, self::$types)]);
        }
    }

    /**
     * Removes type loader by class
     *
     * @param string $typeClass
     */
    public static function removeByClass($typeClass)
    {
        foreach (self::$types as $type) {
            if ($type instanceof $typeClass) {
                self::remove($type);
            }
        }
    }

    /**
     * Returns type loader instance for specified filename
     *
     * @param string $fileName
     * @return TypeInterface|bool
     */
    public static function type($fileName)
    {
        /* @var TypeInterface $type */
        foreach (self::$types as $type) {
            if ($type->isAvailable($fileName)) {
                return $type;
            }
        }

        return false;
    }

    /**
     * Loads file content by its loader and returns array with data
     * If no loader found, it returns false
     *
     * @param string $fileName
     * @return array|bool
     */
    public static function load($fileName)
    {
        $type = self::type($fileName);
        if ($type === false) {
            return false;
        }

        return $type->load($fileName);
    }
}