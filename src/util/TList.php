<?php

namespace phpdk\util;


use phpdk\lang\ScalarInterface;

class TList extends AbstractCollection
{
    protected $list = [];

    protected $template;


    public function getTemplateClassName(): string
    {
        return (string)$this->template;
    }


    public function instanceOfTemplate(string $className): bool
    {
        return $this->getTemplateClassName() == $className;
    }



    public function add($index, $object = null): void
    {
        if ($object == null) {
            $this->list[] = $this->createObject($index);
        } else {
            $this->list[$index] = $this->createObject($object);
        }
    }

    /**
     * @param $index
     * @param $object
     *
     * @return mixed
     */
    public function set($index, $object)
    {
        $previously = $this->get($index);
        $this->add($index, $object);

        return $previously;
    }

    /**
     * @param $index
     *
     * @return mixed
     */
    public function get($index)
    {
        return $this->list[$index];
    }

    public function contains($object): bool
    {
        return $this->indexOf($object) !== -1;
    }


    public function indexOf($object): int
    {
        $object = $this->createObject($object);
        if ($object instanceof ScalarInterface) {
            foreach ($this->list as $index => $value) {
                if ($value->getValue() == $object->getValue()) {
                    return $index;
                }
            }

        } else {
            foreach ($this->list as $index => $value) {
                if ($value == $object) {
                    return $index;
                }
            }
        }

        return -1;
    }

    /**
     * @param int $index
     *
     * @return mixed
     */
    public function remove($index)
    {
        $removeObject = $this->get($index);
        unset($this->list[$index]);

        return $removeObject;
    }

    public function count(): int
    {
        return count($this->list);
    }


    public function getIterator()
    {
        return new \ArrayIterator($this->list);
    }
}