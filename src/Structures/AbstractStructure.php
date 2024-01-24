<?php

declare(strict_types=1);

namespace Avtocod\Specifications\Structures;

use ArrayIterator;
use LogicException;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @template AbstractStructureData of array<string, mixed>
 *
 * @implements \ArrayAccess<string,mixed>
 * @implements \IteratorAggregate<string,mixed>
 */
abstract class AbstractStructure implements Arrayable, Jsonable, \ArrayAccess, \IteratorAggregate
{
    /**
     * Create a new structure instance.
     *
     * @param AbstractStructureData|null $raw_data
     */
    public function __construct($raw_data = null)
    {
        $this->configure($raw_data);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \JsonException
     *
     * @deprecated Will be removed in closest major release
     */
    public function toJson($options = 0): string
    {
        return (string) \json_encode($this->toArray(), JSON_THROW_ON_ERROR | $options);
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator<string,mixed>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * Whether a offset exists.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return \property_exists($this, $offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset): mixed
    {
        return $this->{$offset};
    }

    /**
     * @inheritdoc
     *
     *  @throws LogicException
     */
    public function offsetSet($offset, $value): void
    {
        throw new LogicException('Changing are not allowed');
    }

    /**
     * @inheritdoc
     *
     *  @throws LogicException
     */
    public function offsetUnset($offset): void
    {
        throw new LogicException('Changing are not allowed');
    }

    /**
     * Configure itself.
     *
     * @param AbstractStructureData|null $raw_data
     *
     * @return void
     *
     * @deprecated Will be removed in the closest major release
     */
    abstract protected function configure($raw_data);
}
