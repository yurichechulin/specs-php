<?php

declare(strict_types=1);

namespace Avtocod\Specifications\Structures;

use ArrayIterator;
use LogicException;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements \ArrayAccess<string,mixed>
 * @implements \IteratorAggregate<string,mixed>
 * @implements Arrayable<string,mixed>
 */
abstract class AbstractStructure implements Arrayable, Jsonable, \ArrayAccess, \IteratorAggregate
{
    /**
     * Create a new structure instance.
     *
     * @param mixed|null $raw_data
     */
    public function __construct($raw_data = null)
    {
        if (\is_iterable($raw_data)) {
            $this->configure($raw_data);
        }
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
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return \is_string($offset) && \property_exists($this, $offset);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->{$offset};
    }

    /**
     * Offset to set.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @throws LogicException
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        throw new LogicException('Changing are not allowed');
    }

    /**
     * Offset to unset.
     *
     * @param mixed $offset
     *
     * @throws LogicException
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        throw new LogicException('Changing are not allowed');
    }

    /**
     * Configure itself.
     *
     * @param mixed[]|iterable $raw_data
     *
     * @return void
     *
     * @deprecated Will be removed in closest major release
     */
    abstract protected function configure($raw_data);
}
