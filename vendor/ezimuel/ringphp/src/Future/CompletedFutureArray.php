<?php
namespace GuzzleHttp\Ring\Future;

/**
 * Represents a future array that has been completed successfully.
 */
class CompletedFutureArray extends CompletedFutureValue implements FutureArrayInterface
{
    public function __construct(array $result)
    {
        parent::__construct($result);
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->result[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->result[$offset];
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->result[$offset] = $value;
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->result[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function count()
    {
        return count($this->result);
    }

    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new \ArrayIterator($this->result);
    }
}
