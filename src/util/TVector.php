<?php

namespace phpdk\util;


use phpdk\lang\TInt;
use phpdk\lang\TObject;

class TVector extends AbstractList implements CollectionInterface
{
    protected $list = [];

    public function get($index)
    {
        // TODO: Implement get() method.
    }

    public function set($index, $element)
    {
        // TODO: Implement set() method.
    }

    public function add($index, $element = null)
    {
        if (TInt::instanceof($index)) {
            $index = new TInt($index);
            $this->list[$index->getValue()] = $element;
        } else {
            $this->list[] = $element;
        }
    }

    public function addElement($object)
    {
        $this->add($object);
    }

    public function capacity(): int
    {
        return count($this->list);
    }

    public function clear(): void
    {
        $this->list = [];
    }

    public function clone(): self
    {
        return new static($this->list);
    }



    public function remove($index)
    {
        // TODO: Implement remove() method.
    }

    public function addAll($collection)
    {
        // TODO: Implement addAll() method.
    }

    public function removeAll($collection)
    {
        // TODO: Implement removeAll() method.
    }

    public function equals($object): bool
    {
        // TODO: Implement equals() method.
    }
}