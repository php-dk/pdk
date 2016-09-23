<?php

namespace Types\interfaces;

interface ImageInterface extends Type
{
    /**
     * @param array $size
     *
     * @return $this
     */
    public function setSize(array $size);

    public function toString(): string;

    public function __toString();
}