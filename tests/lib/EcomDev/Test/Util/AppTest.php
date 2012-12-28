<?php

namespace EcomDev\Test\Util;

class AppTest extends \PHPUnit_Framework_TestCase
{
    const APP_CLASS = '\\EcomDev\\Test\\Util\\App';
    const TEST_MAGE_CLASS = '\\EcomDev\\Test\\Util\\App\\MageTest';

    /**
     * Includes test mock class and sets it as mageClass to App utility
     *
     */
    protected function setUp()
    {
        require_once dataFilePath(__FILE__, 'testClasses');
        Reflection::setProperty(self::APP_CLASS, 'mageClass', self::TEST_MAGE_CLASS);
    }

    /**
     * Tests availability of Mage class
     *
     *
     */
    public function testIsAvailable()
    {
        $this->assertTrue(App::isAvailable());
        Reflection::setProperty(self::APP_CLASS, 'mageClass', App::DEFAULT_MAGE_CLASS);
        $this->assertFalse(App::isAvailable());
    }


    /**
     * Restores mageClass property value
     *
     */
    protected function tearDown()
    {
        Reflection::setProperty(self::APP_CLASS, 'mageClass', App::DEFAULT_MAGE_CLASS);
    }
}
