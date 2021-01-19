<?php

namespace Avtocod\Specifications\Tests\Structures;

use Illuminate\Support\Str;
use Avtocod\Specifications\Structures\VehicleDrivingWheelsType;

/**
 * @covers \Avtocod\Specifications\Structures\VehicleDrivingWheelsType<extended>
 */
class VehicleDrivingWheelsTypeTest extends AbstractStructureTestCase
{
    /**
     * @var VehicleDrivingWheelsType
     */
    protected $instance;

    /**
     * {@inheritdoc}
     */
    public function testConfigure(): void
    {
        $this->instance = $this->factory($input = [
            'id'   => $id = Str::random(),
            'name' => $name = Str::random(),
        ]);

        $this->assertSame($id, $this->instance->getId());
        $this->assertSame($name, $this->instance->getName());

        $this->assertSame($input, $this->instance->toArray());
    }

    /**
     * @return void
     */
    public function testConfigureWithNulls(): void
    {
        $this->instance = $this->factory($input = [
            'id'   => null,
            'name' => null,
        ]);

        $this->assertNull($this->instance->getId());
        $this->assertNull($this->instance->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function testArrayAccess(): void
    {
        $this->instance = $this->factory([
            'name' => $name = Str::random(),
        ]);

        $this->assertInstanceOf(\ArrayAccess::class, $this->instance);
        $this->assertArrayHasKey('name', $this->instance);
        $this->assertSame($name, $this->instance['name']);

        $this->assertFalse(isset($this->instance['bar']));
    }

    /**
     * {@inheritdoc}
     *
     * @return VehicleDrivingWheelsType
     */
    protected function factory(...$arguments): VehicleDrivingWheelsType
    {
        return new VehicleDrivingWheelsType(...$arguments);
    }
}
