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

/**
 * Reflection helper class
 *
 *
 */
class Reflection
{

    const REGEXP_ANNOTATION = '/^\s*[\\*]?\s*@([a-zA-Z][a-zA-Z_0-9]*)[\t ]*(.*)$/m';

    /**
     * Cache of reflection objects
     *
     * @var array
     */
    protected static $cache = array();

    /**
     * Returns reflection information about class or object
     *
     * @param string|object $classOrInstance
     * @return \ReflectionClass|\ReflectionObject
     * @throws \InvalidArgumentException
     */
    public static function reflect($classOrInstance)
    {
        $cacheId = __METHOD__ . (is_object($classOrInstance) ? spl_object_hash($classOrInstance) : $classOrInstance);

        if (isset(self::$cache[$cacheId])) {
            return self::$cache[$cacheId];
        }

        if (is_string($classOrInstance) && class_exists($classOrInstance)) {
            $reflection = new \ReflectionClass($classOrInstance);
        } elseif (is_object($classOrInstance)) {
            $reflection = new \ReflectionObject($classOrInstance);
        } else {
            throw new \InvalidArgumentException('$classOrInstance should be a valid class name or an object instance');
        }

        self::$cache[$cacheId] = $reflection;
        return $reflection;
    }

    /**
     * Sets property value to an object or a class
     *
     * @param string|object $classOrInstance
     * @param string $name
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public static function setProperty($classOrInstance, $name, $value)
    {
        $reflection = self::reflect($classOrInstance);

        if (!$reflection->hasProperty($name)) {
            throw new \InvalidArgumentException('$name argument should be an actual property that is available');
        }

        $property = $reflection->getProperty($name);

        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }

        if ($property->isStatic()) {
            $property->setValue($value);
        } else {
            $property->setValue($classOrInstance, $value);
        }

        if (!$property->isPublic()) {
            $property->setAccessible(false);
        }
    }

    /**
     * Retrieves property value of an object or a class
     *
     * @param $classOrInstance
     * @param $name
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public static function getProperty($classOrInstance, $name)
    {
        $reflection = self::reflect($classOrInstance);

        if (!$reflection->hasProperty($name)) {
            throw new \InvalidArgumentException('$name argument should be an actual property that is available');
        }

        $property = $reflection->getProperty($name);

        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }

        if ($property->isStatic()) {
            $value = $property->getValue();
        } else {
            $value = $property->getValue($classOrInstance);
        }

        if (!$property->isPublic()) {
            $property->setAccessible(false);
        }

        return $value;
    }

    /**
     * Calls method on the class with arguments as associative array
     *
     * @param string|object $classOrInstance
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public static function callArgs($classOrInstance, $name, array $arguments)
    {
        $reflection = self::reflect($classOrInstance);

        $method = $reflection->getMethod($name);

        if (!$method->isPublic()) {
            $method->setAccessible(true);
        }

        $callScope = $method->isStatic() ? null : $classOrInstance;
        $result = $method->invokeArgs($callScope, $arguments);

        if (!$method->isPublic()) {
            $method->setAccessible(false);
        }

        return $result;
    }

    /**
     * Calls method on the class with arguments as flat list
     *
     * @param string|object $classOrInstance
     * @param string $method
     * @return mixed
     */
    public static function call($classOrInstance, $method/*, $argument1, ... */)
    {
        $arguments = array_slice(func_get_args(), 2);
        return self::callArgs($classOrInstance, $method, $arguments);
    }

    /**
     * Returns array of annotations based for specified class or method
     *
     * The data is returned in two variants:
     * array('class' => array(...)) if only class annotations requested
     * or array('class' => array(), 'method' => array()) if it method argument is specified
     *
     * @param string|object $classOrInstance
     * @param string|null $method
     * @return array
     */
    public static function getAnnotations($classOrInstance, $method = null)
    {
        $reflection = self::reflect($classOrInstance);

        $result = array(
            'class' => self::parseAnnotations($reflection->getDocComment())
        );

        if ($method !== null && $reflection->hasMethod($method)) {
            $methodReflection = $reflection->getMethod($method);
            $result['method'] = self::parseAnnotations($methodReflection->getDocComment());
        }

        return $result;
    }

    /**
     * Parses annotations from doc comment of method
     *
     * @param string $docComment
     * @return array
     */
    public static function parseAnnotations($docComment)
    {
        if (is_string($docComment) && preg_match_all(self::REGEXP_ANNOTATION, $docComment, $matches)) {
            $result = array();
            foreach ($matches[1] as $index => $name) {
                if ($matches[2][$index] === '') {
                    $value = null;
                } else {
                    $value = $matches[2][$index];
                }
                $result[$name][] = $value;
            }
            return $result;
        }

        return array();
    }
}