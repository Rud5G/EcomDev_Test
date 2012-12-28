<?php

namespace EcomDev\Test\DataLoader;

use org\bovigo\vfs\vfsStream;

class TypeYamlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TypeYaml
     */
    protected $type = null;

    /**
     * Prepares environment
     *
     */
    protected function setUp()
    {
        $this->type = new TypeYaml();
        vfsStream::setup();
        vfsStream::create(includeDataFile(__DIR__, 'fsStructure'));
    }

    /**
     * @param $fileName
     * @param $expectedValue
     * @dataProvider dataProviderTestIsAvailable
     */
    public function testIsAvailable($fileName, $expectedValue)
    {
        $fileName = vfsStream::url($fileName);
        $this->assertEquals($expectedValue, $this->type->isAvailable($fileName));
    }

    /**
     * Tests data load method
     *
     * @param $fileName
     * @param $expectedValue
     * @dataProvider dataProviderTestLoad
     */
    public function testLoad($fileName, $expectedValue)
    {
        $fileName = vfsStream::url($fileName);
        $this->assertEquals($expectedValue, $this->type->load($fileName));
    }

    /**
     * Data provider for test for isAvailable method
     *
     * @return mixed
     */
    public function dataProviderTestIsAvailable()
    {
        return includeDataFile(__FILE__, __FUNCTION__);
    }

    /**
     * Data provider for test of load method
     *
     * @return mixed
     */
    public function dataProviderTestLoad()
    {
        return includeDataFile(__FILE__, __FUNCTION__);
    }
}