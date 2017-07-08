<?php

namespace PDK\lang;


trait ArrayAccessTrait
{
    public function &getArray()
    {
        return $this->array;
    }

    public function offsetExists($offset)
    {
        return isset($this->getArray()[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->getArray()[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if ($offset == null) {
            $this->getArray()[] = $value;

        } else {
            $this->getArray()[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if (is_string($this->getArray())) {
            throw new Exception('Cannot unset string offsets');
        }
        unset($this->getArray()[$offset]);
    }
}