<?php

namespace EcomDev\Test\Container\Indexer;

class ConfigAbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigAbstract
     */
    protected $indexer;

    protected function setUp()
    {
        $this->indexer = $this->getMockForAbstractClass('\\EcomDev\\Test\\Container\\Indexer\\ConfigAbstract');
    }

    /**
     * It should not be possible to set source from non-xml configuration
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $source should be an instance of SimpleXmlElement class
     */
    public function testSetNonXmlSource()
    {
        $this->indexer->setSource(array('non-xml'));
    }

    /**
     * Test that xml source is set correctly
     *
     */
    public function testSetXmlSource()
    {
        $source = new \SimpleXMLElement('<config />');
        $this->indexer->setSource($source);
        $this->assertAttributeSame($source, 'source', $this->indexer);
    }
}
