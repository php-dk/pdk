<?php

namespace ToolsPhp\Types\trains;


use phptools\PgSqlOrm\exception\Exception;
use ToolsPhp\Types\TObject;

class TStrictObject extends TObject
{
    final public function __get($name)
    {
        throw new Exception();
    }

    final public function __set($name, $value)
    {
        throw new Exception();
    }

    final public function __call()
    {
        throw new Exception();
    }
}