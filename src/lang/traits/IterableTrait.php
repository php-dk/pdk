<?php

namespace PDK\lang\traits;


trait IterableTrait
{

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

}