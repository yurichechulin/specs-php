<?php

namespace Avtocod\Specifications\Tests\Structures;

use Avtocod\Specifications\Structures\Field;

/**
 * @covers \Avtocod\Specifications\Structures\Field<extended>
 */
class FieldTest extends AbstractStructureTestCase
{
    /**
     * @var Field
     */
    protected $instance;

    /**
     * {@inheritdoc}
     */
    public function testConfigure(): void
    {
        $this->instance = $this->factory($input = [
            'path'        => $path = 'some path',
            'description' => $description = 'some description',
            'types'       => $types = ['some', 'types'],
            'fillable_by' => $fillable_by = ['some.source', 'another.source'],
        ]);

        $this->assertSame($path, $this->instance->getPath());
        $this->assertSame($description, $this->instance->getDescription());
        $this->assertSame($types, $this->instance->getTypes());
        $this->assertSame($fillable_by, $this->instance->getFillableBy());

        $this->assertSame($input, $this->instance->toArray());
    }

    /**
     * @return void
     */
    public function testConfigureWithNulls(): void
    {
        $this->instance = $this->factory($input = [
            'path'        => null,
            'description' => null,
            'types'       => null,
            'fillable_by' => null,
        ]);

        $this->assertNull($this->instance->getPath());
        $this->assertNull($this->instance->getDescription());
        $this->assertNull($this->instance->getTypes());
        $this->assertNull($this->instance->getFillableBy());
    }

    /**
     * {@inheritdoc}
     */
    public function testArrayAccess(): void
    {
        $this->instance = $this->factory([
            'path' => $path = 'some path',
        ]);

        $this->assertTrue(isset($this->instance['path']));
        $this->assertSame($path, $this->instance['path']);

        $this->assertFalse(isset($this->instance['bar']));
    }

    /**
     * @return void
     */
    public function testNesting(): void
    {
        $this->instance = $this->factory([
            'path' => 'some path',
        ]);

        $this->assertSame(0, $this->instance->nestingDepth());
        $this->assertFalse($this->instance->isNested());

        $this->instance = $this->factory([
            'path' => 'some.path[].included',
        ]);

        $this->assertSame(1, $this->instance->nestingDepth());
        $this->assertTrue($this->instance->isNested());

        $this->instance = $this->factory([
            'path' => 'some.path[].included.in[].me',
        ]);

        $this->assertSame(2, $this->instance->nestingDepth());
        $this->assertTrue($this->instance->isNested());
    }

    /**
     * @return void
     */
    public function testPathParts(): void
    {
        $this->instance = $this->factory([
            'path' => 'some.path[].included',
        ]);
        $this->assertSame(['some', 'path[]', 'included'], $this->instance->getPathParts());

        $this->instance = $this->factory([
            'path' => 'some...foo.....bar',
        ]);

        $this->assertSame(['some', 'foo', 'bar'], $this->instance->getPathParts());

        $this->instance = $this->factory([
            'path' => null,
        ]);
        $this->assertSame([], $this->instance->getPathParts());
    }

    /**
     * {@inheritdoc}
     *
     * @return Field
     */
    protected function factory(...$arguments): Field
    {
        return new Field(...$arguments);
    }
}
