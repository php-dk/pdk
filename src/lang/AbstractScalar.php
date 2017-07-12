<?php

namespace phpdk\lang;

use phpdk\lang\exceptions\Exception;
use phpdk\system\Lang;

abstract class AbstractScalar extends TObject implements CompareInterface, ScalarInterface
{
    protected function compare(string $operator, $object): bool
    {
        if ($object instanceof ScalarInterface) {
            $v1 = $object->getValue();
            $self = $this->getValue();

        } elseif (is_scalar($object)) {
            $v1 = $object;
            $self = $this->getValue();
        } else {
            throw new Exception();
        }

        return Lang::compare($self, $operator, $v1);
    }

    public function less($object): bool
    {
        return $this->compare('<', $object);
    }

    public function more($object): bool
    {
        return $this->compare('>', $object);
    }

    public function moreEquals($object): bool
    {
        return $this->compare('>=', $object);
    }

    public function lessEquals($object): bool
    {
        return $this->compare('<=', $object);
    }

    public function notEqual($object): bool
    {
        return $this->compare('!=', $object);
    }

    public function equals($object): bool
    {
        return $this->compare('===', $object);
    }
}