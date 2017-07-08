<?php

namespace ToolsPhp\Types\core;

class ClassName
{
    protected $className;

    /**
     * ClassName constructor.
     * @param $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
    }


    public function getClassName(): string
    {
        return $this->className;
    }


}