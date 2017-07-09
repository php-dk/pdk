<?php

namespace phpdk\util;


abstract class AbstractList extends AbstractCollection
{
    abstract public function get($index);

    abstract public function set($index, $element);

}