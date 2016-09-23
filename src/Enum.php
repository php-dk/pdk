<?php

namespace Types;


use ArrayIterator;
use ReflectionClass;
use Types\exception\TypeException;
use Types\interfaces\Type;
use Types\trains\Enum as TraitEnum;

abstract class Enum  implements \IteratorAggregate, Type
{
   use TraitEnum;
}

class EnumException extends TypeException {
    
}