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

namespace EcomDev\Test\Util;

class ReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Supplies test classes for test case
     *
     */
    public static function setUpBeforeClass()
    {
        require_once dirname(__FILE__)  . DIRECTORY_SEPARATOR . '_testClasses.php';
    }

    /**
     * Resets static properties on example class
     *
     */
    protected function setUp()
    {
        TestExampleClass::reset();
    }

    /**
     * Tests retrieving of class reflection by class name
     *
     */
    public function testReflectClass()
    {
        $class = TestExampleClass::$class;
        $reflection = Reflection::reflect($class);
        $this->assertInstanceOf('ReflectionClass', $reflection);

        // Assert that object is the same on second call as well,
        // e.g. retrieved from cache
        $this->assertSame($reflection, Reflection::reflect($class));
    }

    /**
     * Tests retrieving of reflection by object instance
     *
     */
    public function testReflectInstance()
    {
        $instance = new TestExampleClass();
        $reflection = Reflection::reflect($instance);
        $this->assertInstanceOf('ReflectionObject', $reflection);
        // Assert that object is the same on second call as well,
        // e.g. retrieved from cache
        $this->assertSame($reflection, Reflection::reflect($instance));
    }

    /**
     * Tests error in reflection retrieval
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $classOrInstance should be a valid class name or an object instance
     */
    public function testReflectError()
    {
        Reflection::reflect('SomeNonExistentClass');
    }

    /**
     * Test of setting a static property value via reflection util
     */
    public function testSetStaticValue()
    {
        $this->assertAttributeEmpty('publicStaticProperty', TestExampleClass::$class);
        $this->assertAttributeEmpty('protectedStaticProperty', TestExampleClass::$class);
        $this->assertAttributeEmpty('privateStaticProperty', TestExampleClass::$class);

        Reflection::setProperty(TestExampleClass::$class, 'publicStaticProperty', 'myValue');
        $this->assertAttributeSame('myValue', 'publicStaticProperty', TestExampleClass::$class);

        Reflection::setProperty(TestExampleClass::$class, 'protectedStaticProperty', 'myValue');
        $this->assertAttributeSame('myValue', 'protectedStaticProperty', TestExampleClass::$class);

        Reflection::setProperty(TestExampleClass::$class, 'privateStaticProperty', 'myValue');
        $this->assertAttributeSame('myValue', 'privateStaticProperty', TestExampleClass::$class);
    }

    /**
     * Test of setting value via reflection util
     */
    public function testSetProperty()
    {
        $instance = new TestExampleClass();

        $this->assertAttributeEmpty('publicProperty', $instance);
        $this->assertAttributeEmpty('protectedProperty', $instance);
        $this->assertAttributeEmpty('privateProperty', $instance);

        Reflection::setProperty($instance, 'publicProperty', 'myValue');
        $this->assertAttributeSame('myValue', 'publicProperty', $instance);

        Reflection::setProperty($instance, 'protectedProperty', 'myValue');
        $this->assertAttributeSame('myValue', 'protectedProperty', $instance);

        Reflection::setProperty($instance, 'privateProperty', 'myValue');
        $this->assertAttributeSame('myValue', 'privateProperty', $instance);
    }

    /**
     * Test setting error situation
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $name argument should be an actual property that is available
     */
    public function testSetPropertyError()
    {
        Reflection::setProperty(TestExampleClass::$class, 'unknownProperty', 'myValue');
    }

    /**
     * Test of getting a static property value via reflection util
     */
    public function testGetStaticValue()
    {
        $value = 'myValue';
        Reflection::setProperty(TestExampleClass::$class, 'publicStaticProperty', $value);
        $this->assertSame(
            $value,
            Reflection::getProperty(TestExampleClass::$class, 'publicStaticProperty')
        );

        Reflection::setProperty(TestExampleClass::$class, 'protectedStaticProperty', $value);
        $this->assertSame(
            $value,
            Reflection::getProperty(TestExampleClass::$class, 'protectedStaticProperty')
        );

        Reflection::setProperty(TestExampleClass::$class, 'privateStaticProperty', $value);
        $this->assertSame(
            $value,
            Reflection::getProperty(TestExampleClass::$class, 'privateStaticProperty')
        );
    }

    /**
     * Test of getting value via reflection util
     */
    public function testGetProperty()
    {
        $instance = new TestExampleClass();
        $value = 'myValue';

        Reflection::setProperty($instance, 'publicProperty', $value);
        $this->assertSame($value, Reflection::getProperty($instance, 'publicProperty'));

        Reflection::setProperty($instance, 'protectedProperty', $value);
        $this->assertSame($value, Reflection::getProperty($instance, 'protectedProperty'));

        Reflection::setProperty($instance, 'privateProperty', $value);
        $this->assertSame($value, Reflection::getProperty($instance, 'privateProperty'));

    }

    /**
     * Test getting value error situation
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $name argument should be an actual property that is available
     */
    public function testGetPropertyError()
    {
        Reflection::getProperty(TestExampleClass::$class, 'unknownProperty', 'myValue');
    }

    /**
     * Tests call arguments of method
     *
     * @dataProvider dataProviderTestCallArgs
     */
    public function testCallStaticArgs($args)
    {
        $this->assertSame(
            $args,
            Reflection::callArgs(TestExampleClass::$class, 'someStaticPublicMethod', $args)
        );

        $this->assertSame(
            $args,
            Reflection::callArgs(TestExampleClass::$class, 'someStaticProtectedMethod', $args)
        );

        $this->assertSame(
            $args,
            Reflection::callArgs(TestExampleClass::$class, 'someStaticPrivateMethod', $args)
        );
    }

    /**
     * Tests call arguments of method
     *
     * @dataProvider dataProviderTestCallArgs
     */
    public function testCallArgs($args)
    {
        $instance = new TestExampleClass();
        $this->assertSame(
            $args,
            Reflection::callArgs($instance, 'somePublicMethod', $args)
        );

        $this->assertSame(
            $args,
            Reflection::callArgs($instance, 'someProtectedMethod', $args)
        );

        $this->assertSame(
            $args,
            Reflection::callArgs($instance, 'somePrivateMethod', $args)
        );
    }

    /**
     * Tests call arguments of method
     *
     * @dataProvider dataProviderTestCallArgs
     */
    public function testCall($args)
    {
        $instance = new TestExampleClass();


        $callArgs = $args;
        $method = 'somePublicMethod';
        array_unshift($callArgs, '');
        array_unshift($callArgs, $instance);
        $callArgs[1] = &$method; // Set method as reference

        $callable = array('\\EcomDev\\Test\\Util\\Reflection', 'call');

        $this->assertSame(
            $args,
            call_user_func_array($callable, $callArgs)
        );

        $method = 'someProtectedMethod';

        $this->assertSame(
            $args,
            call_user_func_array($callable, $callArgs)
        );

        $method = 'somePrivateMethod';

        $this->assertSame(
            $args,
            call_user_func_array($callable, $callArgs)
        );
    }

    /**
     * Data provider for call arguments test
     *
     * @return array
     */
    public function dataProviderTestCallArgs()
    {
        return array(
            array(
                array('argument1')
            ),
            array(
                array('argument1', 'argument2')
            ),
            array(
                array('argument1', 'argument2', 'argument3')
            ),
            array(
                array('argument1', 'argument2', 'argument3', 'argument4')
            )
        );
    }

}
