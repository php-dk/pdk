<?php

namespace Types\objects;


use Types\interfaces\ToJsonInterface;
use Types\interfaces\Type;
use Types\JSON;

class Point implements Type, ToJsonInterface
{
    protected $_x;
    protected $_y;

    public function __construct($x, $y)
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    /**
     * @param $x
     * @param $y
     *
     * @return \Types\objects\Point
     */
    public static function new($x, $y): self
    {
        return new static($x, $y);
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->_x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->_y;
    }

    public function toArray(): array 
    {
        return [
            'x' => $this->_x,
            'y' => $this->_y
        ];
    }


    public function toJson(): string
    {
        return JSON::encode($this->toArray());
    }
}