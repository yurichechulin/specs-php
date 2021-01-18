<?php

namespace Avtocod\Specifications\Tests\Structures;

use Avtocod\Specifications\Structures\VehicleType;

/**
 * @covers \Avtocod\Specifications\Structures\VehicleType<extended>
 */
class VehicleTypeTest extends AbstractStructureTestCase
{
    /**
     * @var VehicleType
     */
    protected $instance;

    /**
     * Test object array access.
     *
     * @return void
     */
    public function testArrayAccess(): void
    {
        $this->instance = $this->factory($input = [
            'name'         => $name = 'some name',
            'id'           => $id_type = 'some id',
            'alias'        => $alias = 'some alias',
        ]);

        $this->assertSame($id_type, $this->instance->getId());
        $this->assertSame($name, $this->instance->getName());
        $this->assertSame($alias, $this->instance->getAlias());

        $this->assertSame($input, $this->instance->toArray());
    }

    /**
     * Test self-configuration method.
     *
     * @return void
     */
    public function testConfigure(): void
    {
        $this->instance = $this->factory($input = [
            'id'           => null,
            'name'         => null,
            'alias'        => null,
        ]);

        $this->assertNull($this->instance->getId());
        $this->assertNull($this->instance->getName());
        $this->assertNull($this->instance->getAlias());
    }

    /**
     * Tested instance factory.
     *
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    protected function factory(...$arguments)
    {
        return new VehicleType(...$arguments);
    }
}
