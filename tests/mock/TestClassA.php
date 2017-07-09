<?php

namespace phpdk\tests\mock;


class TestClassA
{
    public $i = 0;

    public function __construct($i)
    {
        $this->i = $i;
    }

    public function getValue()
    {
        return $this->i;
    }
}