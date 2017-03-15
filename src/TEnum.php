<?php

namespace ToolsPhp\Types;

use ToolsPhp\Types\exception\TypeException;
use ToolsPhp\Types\interfaces\Type;
use ToolsPhp\Types\trains\Enum as TraitEnum;

abstract class TEnum  implements \IteratorAggregate, Type
{
   use TraitEnum;
}

class TEnumException extends TypeException {
    
}