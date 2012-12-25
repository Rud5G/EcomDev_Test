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

/** test classes that are used for reflection tests */
/**
 * Class comment
 *
 * @someAnnotation some annotation
 * @someAnnotation some annotation2
 * @group somegroup
 */
class TestExampleClass
{
    public static $class = __CLASS__;

    protected $protectedProperty;
    private $privateProperty;
    public $publicProperty;

    protected static $protectedStaticProperty;
    private static $privateStaticProperty;
    public static $publicStaticProperty;

    private function somePrivateMethod()
    {
        return func_get_args();
    }

    protected function someProtectedMethod()
    {
        return func_get_args();
    }

    public function somePublicMethod()
    {
        return func_get_args();
    }

    private static function someStaticPrivateMethod()
    {
        return func_get_args();
    }

    protected static function someStaticProtectedMethod()
    {
        return func_get_args();
    }

    public static function someStaticPublicMethod()
    {
        return func_get_args();
    }

    /**
     * Test method install
     *
     * @test function
     * @map function function
     * @loadFixture somevalue somevalue
     * @loadFixture
     */
    public function annotatedMethod()
    {

    }

    /**
     * Method without annotations
     */
    public function unAnnotatedMethod()
    {

    }

    /**
     * Resets static properties
     *
     */
    public static function reset()
    {
        self::$privateStaticProperty = null;
        self::$protectedStaticProperty = null;
        self::$publicStaticProperty = null;
    }
}