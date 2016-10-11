<?php
namespace ToolsPhp\Types;


use ArrayAccess;
use ArrayIterator;
use ArrayObject;
use Countable;
use Exception;
use Generator;
use Iterator;
use IteratorAggregate;
use Traversable;
use ToolsPhp\Types\exception\TypeException;
use ToolsPhp\Types\interfaces\ToJsonInterface;
use ToolsPhp\Types\interfaces\Type;

class TArray implements Type, ToJsonInterface, ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array
     */
    protected $array = [];

    /**
     * @param $array
     *
     * @return static
     */
    public static function create($array)
    {
        return new static($array);
    }

    /**
     * @param $array
     *
     * @return static
     */
    public static function new($array)
    {
        return new static($array);
    }


    public function __construct($input = null)
    {
        if ($input instanceof \SplObjectStorage) {
            $this->merge($input);
        } elseif (is_object($input) && method_exists($input, 'toArray')) {
            $this->array = $input->toArray();
        } elseif (is_array($input)) {
            $this->array = $input;
        } elseif (null === $input) {
            $this->array = [];
        } else {
            $this->array = [$input];
        }

    }


    /**
     * @return static
     */
    public function values()
    {
        return new static(array_values($this->toArray()));
    }

    /**
     * @return static
     */
    public function flip()
    {
        return new static(array_flip($this->toArray()));
    }

    /**
     * @param $name
     * @param null $defValue
     *
     * @return mixed|null
     */
    public function get(string $name, $defValue = null)
    {
        return $this->array[$name] ?? $defValue;
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
                $res[] = $this->get($attribute);
            }

            return $res;
        }

        return $this->get($index);
    }

    public function offsetSet($index, $newval)
    {
        $this->array[$index] = $newval;
    }

    public function offsetUnset($index)
    {
        if (!isset($this->array[$index])) {
            return;
        }

        unset($this->array[$index]);
    }


    /**
     * @param $key
     *
     * @return mixed|false
     */
    public function findByKey($key)
    {
        return $this->array[$key] ?? false;
    }

    public function removeByValue($value)
    {
        foreach ($this->array as $i => $item) {
            if ($item === $value) {
                unset($this->array[$i]);
            }
        }
    }

    /**
     * @param mixed $value
     */
    public function append($value)
    {
        $this->array[] = $value;
    }

    public function clear()
    {
        $this->array = [];
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return (bool)$this->toArray();
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->array);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->array;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->array);
    }

    /**
     * @return mixed|static
     */
    public function first()
    {
        $res = array_pop($this->array);
        if (is_array($res)) {
            return new static($res);
        }

        return $res;
    }

    /**
     * @param callable $callable
     * @param bool $ignoreError
     *
     * @return \Types\TArray|static
     * @throws Exception
     */
    public function map(callable $callable, $ignoreError = false): self
    {
        $res = [];
        foreach ($this->array as $item) {
            try {
                $res[] = $callable($item);
            } catch (Exception $ex) {
                if (!$ignoreError) {
                    throw $ex;
                }
            }
        }

        return new static($res);
    }

    public function foreach (callable $callable): self
    {
        return $this->map($callable);
    }

    public function unique(): self
    {
        return new static(array_unique($this->array));
    }

    /**
     * @param $namePropertyOrMethod
     *
     * @return TArray
     * @throws Exception
     */
    public function getArrayValuesProperty(string $namePropertyOrMethod): self
    {
        return $this->map(function ($obj) use ($namePropertyOrMethod) {
            if (method_exists($obj, $namePropertyOrMethod)) {
                return $obj->{$namePropertyOrMethod}();
            } elseif (isset($obj->{$namePropertyOrMethod})) {
                return $obj->{$namePropertyOrMethod};
            }

            throw new TArrayException(__CLASS__ . "::getArrayValuesProperty 
            свойство или метод $namePropertyOrMethod не найден в элементах массива");
        });
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
        })->toArray();

        return new TString(implode($delimiter, $array));
    }


    /**
     * @param callable $callable
     *
     * @return \Types\TArray|static
     */
    public function filter(callable $callable): self
    {
        return new static(array_filter($this->array, $callable));
    }

    /**
     * @param string $json
     *
     * @return \Types\TArray|static
     * @throws \Types\JSONException
     */
    public static function createByJson($json): self
    {
        return new static(JSON::decode($json, true));
    }

    /**
     * @return string
     * @throws JSONException
     */
    public function toJson(): string
    {
        return JSON::encode($this->toArray());
    }


    /**
     * @param array|\Traversable $array
     */
    public function merge($array)
    {
        if ($array instanceof Traversable) {
            $array = iterator_to_array($array);
        }

        $this->array = array_merge($this->array, $array);
    }


    /**
     * @param mixed $array
     *
     * @return bool
     */
    public static function isArray($array): bool
    {
        return is_array($array)
        || $array instanceof Traversable
        || $array instanceof Generator
        || $array instanceof ArrayAccess;
    }


    public function offsetExists($offset)
    {
        return $this->findByKey($offset) !== false;
    }
}

class TArrayException extends TypeException
{

}