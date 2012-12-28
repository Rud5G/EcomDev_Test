<?php

namespace EcomDev\Test\Util;

use org\bovigo\vfs\vfsStream;

class FileSystemTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        vfsStream::setup();
        vfsStream::create(
            includeDataFile(__FILE__, 'fsStructure')
        );
    }

    /**
     * Tests set base path method
     *
     *
     */
    public function testSetBasePath()
    {
        $basePath = vfsStream::url('magento');
        FileSystem::setBasePath($basePath);
        $this->assertAttributeSame($basePath, 'basePath', '\\EcomDev\\Test\\Util\\FileSystem');

        // Check that it check Mage.php existance
        $this->setExpectedException('\InvalidArgumentException', 'Base path, that was provided, is not a Magento instance path');
        FileSystem::setBasePath(vfsStream::url('not_magento'));
    }

    /**
     * Tests retrieval of base path
     *
     */
    public function testGetBasePath()
    {
        $basePath = vfsStream::url('magento');
        Reflection::setProperty( '\\EcomDev\\Test\\Util\\FileSystem', 'basePath', $basePath);
        $this->assertSame($basePath, FileSystem::getBasePath());

        // Produce an exception
        Reflection::setProperty( '\\EcomDev\\Test\\Util\\FileSystem', 'basePath', null);
        $this->setExpectedException('\RuntimeException', 'Please specify Magento base path before using this utility');
        FileSystem::getBasePath();
    }

    /**
     * Test Module directory retrieval process
     *
     * @dataProvider dataProviderTestGetModuleDirectory
     */
    public function testGetModuleDirectory($moduleName, $codePool, $expectedResult)
    {
        FileSystem::setBasePath(vfsStream::url('magento'));
        if (is_string($expectedResult)) {
            $expectedResult = new \DirectoryIterator(vfsStream::url($expectedResult));
        }

        $this->assertEquals($expectedResult, FileSystem::getModuleDirectory($moduleName, $codePool));
    }

    /**
     * Data provider for testing module directory retrieval
     *
     * @return array
     */
    public function dataProviderTestGetModuleDirectory()
    {
        return includeDataFile(__FILE__, __FUNCTION__);
    }
}
