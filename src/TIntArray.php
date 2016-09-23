<?php

namespace Types;


class TIntArray extends TArray
{
    public function __construct($array)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$key] = (int)$value;
        }
        
        parent::__construct($newArray);
    }

    public function getSum()
    {
        return array_sum($this->array);
    }


}