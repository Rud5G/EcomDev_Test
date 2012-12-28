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

namespace EcomDev\Test\Container;

use EcomDev\Test\Util\Reflection;

/**
 * Test for abstract container base
 *
 */
class ContainerAbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Container abstract instance for test
     *
     * @var ContainerAbstract|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $container = null;

    /**
     * Sets up container property
     *
     */
    protected function setUp()
    {
       $this->container = $this->getMockForAbstractClass('\\EcomDev\\Test\\Container\\ContainerAbstract');
    }

    /**
     * Tests set source method of abstract container
     *
     */
    public function testSetSource()
    {
        $source = new \stdClass();
        $source->property = rand();
        $this->container->setSource($source);
        $this->assertAttributeSame($source, 'source', $this->container);
    }

    /**
     * Test get source method of abstract container
     */
    public function testGetSource()
    {
        $source = new \stdClass();
        $source->property = rand();
        Reflection::setProperty($this->container, 'source', $source);
        $this->assertSame($source, $this->container->getSource());
    }

    /**
     * Test get source method and initSource method as initializer of abstract container
     *
     */
    public function testGetSourceWithInit()
    {
        $this->assertAttributeSame(null, 'source', $this->container);
        $this->container->expects($this->once())
            ->method('initSource')
            ->will($this->returnSelf());

        $this->container->getSource();
        $this->assertAttributeSame(null, 'source', $this->container);
    }


    /**
     * Test add indexer functionality
     *
     */
    public function testAddIndexer()
    {
       $firstIndexer = function () {};
       $secondIndexer = function () {};

       // Test first indexer add process
       $this->assertAttributeNotContains($firstIndexer, 'indexers', $this->container);
       $this->container->addIndexer('first', $firstIndexer);
       $this->assertAttributeContains($firstIndexer, 'indexers', $this->container);
       // Test second indexer add process
       $this->assertAttributeNotContains($secondIndexer, 'indexers', $this->container);
       $this->container->addIndexer('second', $secondIndexer);
       $this->assertAttributeContains($firstIndexer, 'indexers', $this->container);
       $this->assertAttributeContains($secondIndexer, 'indexers', $this->container);
    }

    public function testRemoveIndexer()
    {
        $firstIndexer = function () {};
        $secondIndexer = function () {};

        Reflection::setProperty(
            $this->container, 'indexers', array(
                'first' => $firstIndexer,
                'second' => $secondIndexer
            )
        );

        $this->container->removeIndexer('first');
        $this->assertAttributeNotContains($firstIndexer, 'indexers', $this->container);

        $this->container->removeIndexer('second');
        $this->assertAttributeNotContains($firstIndexer, 'indexers', $this->container);
        $this->assertAttributeNotContains($secondIndexer, 'indexers', $this->container);
    }

    /**
     * Another index callback, but as class method
     *
     * @return array
     */
    public function indexCallback()
    {
        return array('four' => 'four');
    }

    /**
     * Test of indexers method
     *
     */
    public function testIndex()
    {
        $this->container->addIndexer('first', function() {
            return array('some' => 'data', 'data' => 'some');
        });

        $this->container->addIndexer('second', function() {
            return array('some' => array('data2'), 'data_recursive' => array('some' => array('value')));
        });

        $this->container->addIndexer('third', function() {
            return array('data_recursive' => array('some' => array('value', 'value2')));
        });

        $this->container->addIndexer('fourth', array($this, 'indexCallback'));

        $this->container->setSource(new \stdClass()); // Just have valid source
        $this->assertAttributeEmpty('index', $this->container);
        $this->container->index();
        // Assert that indexer is generating data by merging all values returned by indexer

        $expectedIndex = array(
            'some' => array('data', 'data2'),
            'data' => 'some',
            'data_recursive' => array(
                'some' => array(
                    'value', 'value', 'value2'
                )
            ),
            'four' => 'four'
        );

        $this->assertAttributeSame(
            $expectedIndex,
            'index',
            $this->container
        );

        return $expectedIndex;
    }

    /**
     * Tests getIndex retrieval method
     *
     * @depends testIndex
     */
    public function testGetIndex($expectedIndex)
    {
        Reflection::setProperty($this->container, 'index', $expectedIndex);
        $this->assertSame($expectedIndex, $this->container->getIndex());
    }

    /**
     * Data provider for container abstract test
     *
     * @return array
     */
    public function dataProviderTestFind()
    {
        return includeDataFile(__FILE__, __FUNCTION__);
    }

    /**
     * @param $indexData
     * @param $searchString
     * @param $expectedResult
     *
     * @dataProvider dataProviderTestFind
     */
    public function testFind($indexData, $searchString, $expectedResult)
    {
        Reflection::setProperty($this->container, 'index', $indexData);
        $this->assertSame($expectedResult, $this->container->find($searchString));
    }
}
