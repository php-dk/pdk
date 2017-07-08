<?php

namespace PDK\lang;

use ArrayAccess;
use Countable;
use Traversable;

class TArray extends TObject implements
    Countable,
    ArrayAccess,
    OperationInterface,
    ScalarInterface,
    IterableInterface
{
    protected $array = [];

    use ArrayAccessTrait;

    protected function &getArray()
    {
        return $this->array;
    }

    /**
     * TArray constructor.
     * @param array $array
     */
    public function __construct($array = [])
    {
        if ($array instanceof static) {
            $this->array = $array->array;
        } else {
            $this->array = $array;
        }
    }

    public static function new(array $array = [])
    {
        return new static($array);
    }

    public function equals($object): bool
    {
        return $this->array == $object;
    }

    /**
     * @return TArray
     */
    public function unique(): self
    {
        return new static(array_unique($this->array));
    }


    public function merge($object): self
    {
        if (is_array($object)) {
            $object = $object;
        } elseif (is_iterable($object)) {
            $object = iterator_to_array($object);
        }

        return new static(array_merge($this->array, $object));
    }


    /**
     * @param string $delimiter
     *
     * @return TString
     */
    public function implode(string $delimiter = TString::EMPTY): TString
    {
        $array = $this->map(function ($e) {
            return (string)$e;
        })->getValue();

        return new TString(implode($delimiter, $array));
    }


    public function add($object): self
    {
        $array = $this->array;
        $array[] = $object;

        return new static($array);
    }

    /**
     * @param $object
     * @return bool
     */
    public static function isIterable($object): bool
    {
        return is_iterable($object);
    }

    public function count()
    {
       return count($this->array);
    }

    public function toArray(): self
    {
        return $this;
    }

    /**
     * @return array
     */
    public function getValue()
    {
        return $this->array;
    }

    /**
     * @param callable $fund
     *
     * @return $this;
     */
    public function map(callable $fund)
    {
       $res = [];
       foreach ($this as $item) {
           $res[] = $fund($item);
       }

       return new static($res);
    }

    public function filter(callable $fund)
    {
        $res = [];
        foreach ($this as $item) {
            if ($fund($item)) {
                $res[] = $item;
            }
        }

        return new static($res);
    }

    /**
     * @param mixed $index
     *
     * @return array|mixed|null
     */
    public function offsetGet($index)
    {

        if (strpos($index, ',') !== false) {

            $attributes = explode(', ', $index);
            $res = [];
            foreach ($attributes as $attribute) {
                $res[] = $this->array[$attribute];
            }

            return $res;
        }

        return $this->array[$index];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }


}