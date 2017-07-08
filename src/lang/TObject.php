<?php

namespace PDK\lang;

class TObject
{
    public function equals($object): bool
    {
        return $this == $object;
    }

    final public function toTString(): TString
    {
        return new TString(static::class);
    }

    final public function toString(): string
    {
        return new TString(static::class);
    }

    public function __toString()
    {
        return (string)$this->toTString();
    }
}