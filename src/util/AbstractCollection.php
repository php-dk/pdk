<?php

namespace phpdk\util;

use Countable;
use IteratorAggregate;
use phpdk\lang\exceptions\Exception;
use phpdk\lang\OperationInterface;
use phpdk\lang\TArray;
use phpdk\lang\TObject;
use stdClass;

/**
 * Class TCollection
 * @package phpdk\util
 */
abstract class AbstractCollection extends TObject implements
    IteratorAggregate,
    Countable,
    OperationInterface,
    CollectionInterface
{
    protected $list = [];

    /**
     * @var string
     */
    protected $template = stdClass::class;

    /**
     * Collection constructor.
     *
     * $collection = new TCollection(A::class);
     * $collection = new TCollection(A::class, [...]);
     *
     * $collection = TCollection::new(A::class, [...]);
     *
     * @param array $args
     */
    public function __construct(...$args)
    {
        $this->template = $args[0] ?? stdClass::class;

        $data = $args[1] ?? [];
        foreach ($data as $item) {
            $this->add($item);
        }
    }

    /**
     * @param array ...$args
     *
     * @return self
     */
    public static function new(...$args): self
    {
        return new static(...$args);
    }

    protected function createObject($model)
    {
        if (is_scalar($model)) {
            $template = $this->template;
           return new $template($model);
        }

        if (!is_a($model, $this->template)) {
            throw new Exception("Коллекция не может добавить этот класс ".get_class($model)." $this->template");
        }


        return $model;
    }


    /**
     * Adds obj to the invoking collection. Returns true if obj was added to the collection. Returns false if obj is
     * already a member of the collection, or if the collection does not allow duplicates.
     *
     * @param $model
     */
    public function add($model)
    {
        $this->list[] = $this->createObject($model);
    }

    /**
     * Adds all the elements of c to the invoking collection. Returns true if the operation succeeded (i.e., the
     * elements were added). Otherwise, returns false.
     *
     * @param  $collection
     *
     * @return mixed|void
     * @throws Exception
     */
    public function addAll($collection)
    {
            foreach ($collection as $item) {
                $this->add($item);
            }

    }


    /**
     * Removes all elements from the invoking collection.
     */
    public function clear(): void
    {
        $this->list = [];
    }

    /**
     * Returns true if obj is an element of the invoking collection. Otherwise, returns false.
     *
     * @param $object
     * @return bool
     * @internal param $obj
     *
     */
    public function contains($object): bool
    {
        if ($object instanceof TObject) {
            foreach ($this as $element) {
                if ($object->equals($element)) {
                    return true;
                }
            }

            return false;
        }

        foreach ($this as $element) {
            if ($object == $element) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if the invoking collection contains all elements of c. Otherwise, returns false.
     *
     * @param self $collection
     *
     * @return bool
     */
    public function containsAll(self $collection): bool
    {
        $status = false;
        foreach ($collection as $item) {
            if ($this->contains($item)) {
                $this->remove($item);
                $status = true;
            }
        }

        return $status;
    }

    /**
     * Returns true if the invoking collection and obj are equal. Otherwise, returns false.
     *
     * @param $obj
     *
     * @return bool
     */
    public function equals($obj): bool
    {
        foreach ($this->list as $item) {
            if ($item === $obj) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if the invoking collection is empty. Otherwise, returns false.
     *
     * @return bool
     */
    public function isEmpty() : bool
    {
        return !$this->list;
    }

    public function empty(): bool
    {
        return $this->isEmpty();
    }

    /**
     * @return static
     */
    public static function emptyList()
    {
        return new static([]);
    }

    /**
     * Removes one instance of obj from the invoking collection. Returns true if the element was removed. Otherwise,
     * returns false.
     *
     * @param $index
     *
     * @return bool
     */
    public function remove($index)
    {
        $status = $this->contains($index);
        unset($this->list[$index]);

        return $status;
    }

    /**
     * Removes all elements of c from the invoking collection. Returns true if the collection changed (i.e., elements
     * were removed). Otherwise, returns false.
     *
     * @param self $collection
     *
     * @return bool
     */
    public function removeAll($collection)
    {
        $array = new TArray();
        $isRm = false;
        foreach ($collection as $value) {

            $tmp = false;
            foreach ($this->list as $n => $item) {
                if ($value === $item) {
                    $tmp = true;
                    break;
                }
            }

            if ($tmp) {
                $isRm = true;
                $array->add($value);
            }
        }

        $this->list = $array;

        return $isRm;
    }

    /**Returns the number of elements held in the invoking collection.
     *
     * @return int
     */
    public function size(): int
    {
        return $this->count();
    }

    /**
     * Returns the number of elements held in the invoking collection.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->list);
    }

    public function toArray(): TArray
    {
        return new TArray($this->list);
    }


    /**
     * @return \SplObjectStorage
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->list);
    }
}
