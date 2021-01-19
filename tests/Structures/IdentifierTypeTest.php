<?php

namespace Avtocod\Specifications\Tests\Structures;

use Avtocod\Specifications\Structures\IdentifierType;

/**
 * @covers \Avtocod\Specifications\Structures\IdentifierType<extended>
 */
class IdentifierTypeTest extends AbstractStructureTestCase
{
    /**
     * @var IdentifierType
     */
    protected $instance;

    /**
     * {@inheritdoc}
     */
    public function testConfigure(): void
    {
        $this->instance = $this->factory($input = [
            'type'        => $type = 'some type',
            'description' => $description = 'some description',
        ]);

        $this->assertSame($description, $this->instance->getDescription());
        $this->assertSame($type, $this->instance->getType());

        $this->assertSame($input, $this->instance->toArray());
    }

    /**
     * @return void
     */
    public function testConfigureWithNulls(): void
    {
        $this->instance = $this->factory($input = [
            'description' => null,
            'type'        => null,
        ]);

        $this->assertNull($this->instance->getDescription());
        $this->assertNull($this->instance->getType());
    }

    /**
     * {@inheritdoc}
     */
    public function testArrayAccess(): void
    {
        $this->instance = $this->factory([
            'type' => $type = 'some type',
        ]);

        $this->assertTrue(isset($this->instance['type']));
        $this->assertSame($type, $this->instance['type']);

        $this->assertFalse(isset($this->instance['bar']));
    }

    /**
     * {@inheritdoc}
     *
     * @return IdentifierType
     */
    protected function factory(...$arguments): IdentifierType
    {
        return new IdentifierType(...$arguments);
    }
}
