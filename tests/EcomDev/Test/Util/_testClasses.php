<?php
namespace EcomDev\Test\Util;

/** test classes that are used for reflection tests */
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
     */
    public function methodInstall()
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