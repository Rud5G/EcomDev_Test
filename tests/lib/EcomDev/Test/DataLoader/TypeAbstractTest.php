<?php

namespace EcomDev\Test\DataLoader;

class TypeAbstractTest extends \PHPUnit_Framework_TestCase
{
    const TYPE_ABSTRACT = '\\EcomDev\\Test\\DataLoader\\TypeAbstract';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TypeAbstract
     */
    protected $type = null;

    protected function setUp()
    {
        $this->type = $this->getMockForAbstractClass(self::TYPE_ABSTRACT);
    }

    /**
     * Tests is available method calls
     */
    public function testIsAvailable()
    {
        $this->type->expects($this->exactly(3))
            ->method('isType')
            ->will($this->onConsecutiveCalls(
                true,
                false,
                false
            ));

        $this->type->expects($this->exactly(2))
            ->method('guessFileName')
            ->with('filename')
            ->will($this->onConsecutiveCalls(
                'filename.yaml',
                false
            ));

        // Test with file extension
        $this->assertTrue($this->type->isAvailable('filename.yml'));
        // Test with guessing file
        $this->assertTrue($this->type->isAvailable('filename'));
        // Test with guessing file, but not found
        $this->assertFalse($this->type->isAvailable('filename'));
    }



}
