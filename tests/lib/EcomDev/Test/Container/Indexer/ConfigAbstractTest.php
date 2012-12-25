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
