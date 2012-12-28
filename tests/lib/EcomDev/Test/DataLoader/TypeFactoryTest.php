<?php

namespace EcomDev\Test\DataLoader;

/**
 * Tests type factory for loadable type of factories
 *
 *
 */
class TypeFactoryTest extends \PHPUnit_Framework_TestCase
{
    const TYPE_INTERFACE = '\\EcomDev\\Test\\DataLoader\\TypeInterface';
    const TYPE_FACTORY = '\\EcomDev\\Test\\DataLoader\\TypeFactory';

    /**
     * Used for controlling added types to type factory
     *
     * @var array
     */
    protected $addedTypes = array();

    /**
     * Creates mock objects for test
     *
     *
     */
    protected function setUp()
    {
        $this->addedTypes[] = $this->getMockForAbstractClass(self::TYPE_INTERFACE, array(), 'TypeInterfaceOne');
        $this->addedTypes[] = $this->getMockForAbstractClass(self::TYPE_INTERFACE, array(), 'TypeInterfaceTwo');
        $this->addedTypes[] = $this->getMockForAbstractClass(self::TYPE_INTERFACE, array(), 'TypeInterfaceThree');
    }

    /**
     * Adds types to factory
     */
    protected function addTypesAndAssert()
    {
        TypeFactory::add($this->addedTypes[0]);
        TypeFactory::add($this->addedTypes[1]);
        TypeFactory::add($this->addedTypes[2]);

        $this->assertAttributeContains($this->addedTypes[0], 'types', self::TYPE_FACTORY);
        $this->assertAttributeContains($this->addedTypes[1], 'types', self::TYPE_FACTORY);
        $this->assertAttributeContains($this->addedTypes[2], 'types', self::TYPE_FACTORY);
    }

    /**
     * Test add type to factory
     *
     */
    public function testAdd()
    {
        TypeFactory::add($this->addedTypes[0]);
        $this->assertAttributeContains($this->addedTypes[0], 'types', self::TYPE_FACTORY);
        TypeFactory::add($this->addedTypes[1]);
        $this->assertAttributeContains($this->addedTypes[1], 'types', self::TYPE_FACTORY);
        // Assert that both still added
        $this->assertAttributeContains($this->addedTypes[0], 'types', self::TYPE_FACTORY);
        $this->assertAttributeContains($this->addedTypes[1], 'types', self::TYPE_FACTORY);
    }

    /**
     * Test removal of types
     *
     */
    public function testRemove()
    {
        $this->addTypesAndAssert();
        TypeFactory::remove($this->addedTypes[1]);

        $this->assertAttributeContains($this->addedTypes[0], 'types', self::TYPE_FACTORY);
        $this->assertAttributeNotContains($this->addedTypes[1], 'types', self::TYPE_FACTORY);
        $this->assertAttributeContains($this->addedTypes[2], 'types', self::TYPE_FACTORY);
    }


    /**
     * Test removal of types
     *
     *
     */
    public function testRemoveByClass()
    {
        $this->addTypesAndAssert();
        TypeFactory::removeByClass(get_class($this->addedTypes[1]));

        $this->assertAttributeContains($this->addedTypes[0], 'types', self::TYPE_FACTORY);
        $this->assertAttributeNotContains($this->addedTypes[1], 'types', self::TYPE_FACTORY);
        $this->assertAttributeContains($this->addedTypes[2], 'types', self::TYPE_FACTORY);
    }

    /**
     * Stubs expected type
     *
     * @param int $expectedTypeIndex
     * @param string $fileName
     * @return TypeFactoryTest
     */
    protected function stubAvailableType($expectedTypeIndex, $fileName)
    {
        /* @var \PHPUnit_Framework_MockObject_MockObject $type */
        foreach ($this->addedTypes as $typeIndex => $type) {
            if ($expectedTypeIndex >= $typeIndex) {
                $type->expects($this->once())
                    ->method('isAvailable')
                    ->with($fileName)
                    ->will($this->returnValue($typeIndex == $expectedTypeIndex));
            } else {
                $type->expects($this->never())
                    ->method('isAvailable');
            }
        }
        return $this;
    }

    /**
     * Test type method of factory
     *
     */
    public function testType()
    {
        $this->addTypesAndAssert();
        $this->stubAvailableType(1, 'filename.for.1');
        $this->assertSame($this->addedTypes[1], TypeFactory::type('filename.for.1'));
    }

    /**
     * Tests unknown type of file detection
     *
     */
    public function testTypeFalse()
    {
        $this->addTypesAndAssert();
        $this->stubAvailableType(9999, 'unknown.file.type');
        $this->assertFalse(TypeFactory::type('unknown.file.type'));
    }

    /**
     * Test type method of factory
     *
     */
    public function testLoad()
    {
        $this->addTypesAndAssert();

        $this->stubAvailableType(1, 'filename.for.1');
        $expectedData = array('some_data');
        $this->addedTypes[1]
            ->expects($this->once())
            ->method('load')
            ->will($this->returnValue($expectedData));

        $this->assertSame($expectedData, TypeFactory::load('filename.for.1'));
    }

    /**
     * Tests unknown type of file load
     *
     */
    public function testLoadFalse()
    {
        $this->addTypesAndAssert();
        $this->stubAvailableType(9999, 'unknown.file.type');
        $this->assertFalse(TypeFactory::load('unknown.file.type'));
    }

    /**
     * Clean up added types
     *
     */
    protected function tearDown()
    {
        foreach ($this->addedTypes as $type) {
            TypeFactory::remove($type);
        }
    }
}