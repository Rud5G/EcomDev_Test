<?php

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
        $this->assertSame($expectedResult, $indexer->$indexerName());
    }

    public function dataProviderTestIndexers()
    {
        return includeDataFile(__FILE__, __FUNCTION__);
    }
}