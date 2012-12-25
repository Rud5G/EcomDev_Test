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

use EcomDev\Test\Util\Reflection;
use EcomDev\Test\Container\ContainerAbstract;

/**
 * Test for abstract indexer
 */
class IndexerAbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Indexer instance
     *
     * @var IndexerAbstract|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $indexer;

    protected function setUp()
    {
        $this->indexer = $this->getMockForAbstractClass(
            '\\EcomDev\\Test\\Container\\Indexer\\IndexerAbstract',
            array(), '', true, true, true,
            array('index')
        );
    }

    /**
     * Tests set source method of abstract indexer
     *
     */
    public function testSetSource()
    {
        $source = new \stdClass();
        $source->property = rand();
        $this->indexer->setSource($source);
        $this->assertAttributeSame($source, 'source', $this->indexer);
    }

    /**
     * Tests get source method of abstract indexer
     *
     */
    public function testGetSource()
    {
        $source = new \stdClass();
        $source->property = rand();
        Reflection::setProperty($this->indexer, 'source', $source);
        $this->assertSame($source, $this->indexer->getSource());
    }

    /**
     * Tests set container method of abstract indexer
     *
     */
    public function testSetContainer()
    {
        $container = $this->getMockForAbstractClass('\\EcomDev\\Test\\Container\\ContainerAbstract');
        $this->indexer->setContainer($container);
        $this->assertAttributeSame($container, 'container', $this->indexer);
    }

    /**
     * Tests get container method of abstract indexer
     *
     */
    public function testGetContainer()
    {
        $container = $this->getMockForAbstractClass('\\EcomDev\\Test\\Container\\ContainerAbstract');
        Reflection::setProperty($this->indexer, 'container', $container);
        $this->assertSame($container, $this->indexer->getContainer());
    }

    /**
     * Test __invoke method of indexer
     *
     */
    public function testInvoke()
    {
        $call1Result = array('some', 'value');
        $call2Result = array('some2', 'value2');


        $this->indexer->expects($this->exactly(3))
            ->method('index')
            ->will($this->onConsecutiveCalls(
                $call1Result,
                $call2Result,
                null // Invalid call, but parent invoker should return empty array
            ));


        $source = new \stdClass();
        $source->property = rand();
        /* @var $container ContainerAbstract */
        $container = $this->getMockForAbstractClass('\\EcomDev\\Test\\Container\\ContainerAbstract');
        $container->setSource($source);
        // Supposed to assign to a variable, since php treat
        // invokable properties in class as method of class itself.
        $indexer = $this->indexer;
        $this->assertAttributeEmpty('container', $this->indexer);
        $this->assertAttributeEmpty('source', $this->indexer);
        // First call, first result
        $this->assertSame($call1Result, $indexer($source, $container));
        $this->assertAttributeSame($container, 'container', $this->indexer);
        $this->assertAttributeSame($source, 'source', $this->indexer);
        // Second call, second result
        $this->assertSame($call2Result, $indexer($source, $container));
        // Third call should return array, since invalid indexer data
        $this->assertSame(array(), $indexer($source, $container));
    }
}
