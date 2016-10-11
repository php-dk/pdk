<?php

namespace ToolsPhp\Types;


use ArrayIterator;
use ReflectionClass;
use ToolsPhp\Types\exception\TypeException;
use ToolsPhp\Types\interfaces\Type;
use ToolsPhp\Types\trains\Enum as TraitEnum;

abstract class Enum  implements \IteratorAggregate, Type
{
   use TraitEnum;
}

class EnumException extends TypeException {
    
}