<?php
namespace ToolsPhp\Types\collections;

use Countable;
use IteratorAggregate;
use SplObjectStorage;
use stdClass;
use ToolsPhp\Types\exception\TypeException;
use ToolsPhp\Types\TArray;

class TCollection implements IteratorAggregate, Countable
{
    /** @var  SplObjectStorage */
    protected $data;

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
        $this->data = new SplObjectStorage();

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
            throw new CollectionException('Невозможно добавить в коллекцию скалярный тип');
        }

        if (!$model instanceof $this->template) {
            throw new CollectionException("Коллекция не может добавить этот класс");
        }


        return $model;
    }


    /**
     * Adds obj to the invoking collection. Returns true if obj was added to the collection. Returns false if obj is
     * already a member of the collection, or if the collection does not allow duplicates.
     *
     * @param $model
     *
     * @throws CollectionException
     */
    public function add($model)
    {
        $model = $this->createObject($model);
        $this->data->attach($model);
    }

    /**
     * Adds all the elements of c to the invoking collection. Returns true if the operation succeeded (i.e., the
     * elements were added). Otherwise, returns false.
     *
     * @param static|array $collection
     *
     * @throws CollectionException
     */
    public function addAll($collection)
    {
        if ($collection instanceof static) {
            if ($collection->template !== $this->template) {
                throw new CollectionException(
                    'Невозможно объединить коллекции с разными шаблонами
                ');
            }
        }

        if (TArray::isArray($collection)) {
            foreach ($collection as $item) {
                $this->add($item);
            }
        } else {
            throw new CollectionException('Добавить в коллекцию можно только перебираемые типы');
        }

    }


    /**
     * Removes all elements from the invoking collection.
     */
    public function clear()
    {
        $this->data = new SplObjectStorage();
    }

    /**
     * Returns true if obj is an element of the invoking collection. Otherwise, returns false.
     *
     * @param object $obj
     *
     * @return bool
     */
    public function contains($obj): bool
    {
        return $this->data->contains($obj);
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
        foreach ($this->data as $item) {
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
        return $this->data->count() === 0;
    }

    public function empty(): bool
    {
        return $this->isEmpty();
    }


    /**
     * Removes one instance of obj from the invoking collection. Returns true if the element was removed. Otherwise,
     * returns false.
     *
     * @param $obj
     *
     * @return bool
     */
    public function remove($obj): bool
    {
        $status = $this->contains($obj);
        $this->data->detach($obj);

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
    public function removeAll(self $collection): bool
    {
        $array = new TArray();
        $isRm = false;
        foreach ($collection as $value) {

            $tmp = false;
            foreach ($this->data as $n => $item) {
                if ($value === $item) {
                    $tmp = true;
                    break;
                }
            }

            if ($tmp) {
                $isRm = true;
                $array->append($value);
            }
        }

        $this->data = $array;

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
        return $this->data->count();
    }

    public function toArray(): TArray
    {
        return new TArray($this->data);
    }


    /**
     * @return \SplObjectStorage
     */
    public function getIterator()
    {
        return $this->data;
    }
}

class CollectionException extends TypeException
{

}