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
class ModuleConfigTest extends \PHPUnit_Framework_TestCase
{
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
        $this->assertEquals($expectedResult, $indexer->$indexerName());
    }

    public function dataProviderTestIndexers()
    {
        return includeDataFile(__FILE__, __FUNCTION__);
    }
}