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

namespace EcomDev\Test\Container\Indexer;

/**
 * Module configuration indexer test
 *
 */
use EcomDev\Test\Util\FileSystem;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\visitor\vfsStreamPrintVisitor;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;

class ModuleConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up of Magento file system
     *
     */
    protected function setUp()
    {
        vfsStream::setup('root', null, includeDataFile(__FILE__, 'fsStructure'));
        FileSystem::setBasePath(vfsStream::url('magento'));
    }

    /**
     * Tests indexers based on data provider information
     *
     * @param string $indexerName
     * @param \SimpleXMLElement $xml
     * @param array $expectedResult
     * @dataProvider dataProviderTestIndexers
     */
    public function testIndexers($indexerName, \SimpleXMLElement $xml, $expectedResult)
    {
        $indexer = new ModuleConfig();
        $indexer->setSource($xml);
        // Prevent fatal errors during TDD development
        $this->assertTrue(method_exists($indexer, $indexerName), 'Method is NOT implemented');
        $this->assertEquals($expectedResult, $indexer->$indexerName());
    }

    /**
     * Returns data provider testing various indexer method
     *
     * First argument in a call is a name of the method that will be invoked
     *
     * @return array
     */
    public function dataProviderTestIndexers()
    {
        return includeDataFile(__FILE__, __FUNCTION__);
    }

    /**
     * Tests index method of indexer
     *
     */
    public function testIndex()
    {
        $indexersToCheck = includeDataFile(__FILE__, 'indexList');

        $moduleConfig = $this->getMock(
            '\\EcomDev\\Test\\Container\\Indexer\\ModuleConfig', array_values($indexersToCheck)
        );
        // Check that every method was invoked and data got set correctly
        $expectedResult = array();
        foreach ($indexersToCheck as $indexKey => $indexMethod)
         {
            $expectedResult[$indexKey] = array($indexMethod);
            $moduleConfig->expects($this->once())
                ->method($indexMethod)
                ->will($this->returnValue(array($indexMethod)));
        }

        $this->assertEquals($expectedResult, $moduleConfig->index());
    }
}