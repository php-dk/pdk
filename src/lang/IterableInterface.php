<?php

namespace PDK\lang;


interface IterableInterface extends \IteratorAggregate
{
    public function map(callable $fund);

    public function filter(callable $fund);
}