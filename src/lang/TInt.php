<?php

namespace PDK\lang;


class TInt extends AbstractNumber
{
    /** @var  int|null */
    protected $int;

    /**
     * TInt constructor.
     * @param $int
     */
    public function __construct($int = null)
    {
        if ($int instanceof ScalarInterface) {
            $this->int = $int->getValue();
        } elseif (is_scalar($int)) {
            $this->int = (int)$int;
        }
    }


    public function getValue(): int
    {
        return $this->int;
    }

    public static function parseInt($string, $radix)
    {
        return new static((int)$string);
    }

    public function equals($object): bool
    {
        if ($this->int == null) {
            return false;
        }

        if (is_integer($object)) {
            return $this->int == $object;
        } elseif ($object instanceof static) {
            return $this->int == $object->getValue();
        }

        return false;
    }

    public function __toString()
    {
        return (string)$this->int;
    }

    public function add($object)
    {
        if ($object instanceof TInt) {
            return new static($this->int + $object->int);
        }

        return new static($this->int + (int)(string)$object);
    }

    public static function instanceof ($object): bool
    {
        return is_integer($object) || $object instanceof static;
    }
}