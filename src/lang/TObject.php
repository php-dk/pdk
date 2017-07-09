<?php

namespace phpdk\lang;

class TObject
{
    public function equals($object): bool
    {
        return $this == $object;
    }

    public function toString(): TString
    {
        return new TString(static::class);
    }

    public function __toString()
    {
        return (string)$this->toString();
    }

    public static function instanceof($object): bool
    {
        return $object instanceof static;
    }
}