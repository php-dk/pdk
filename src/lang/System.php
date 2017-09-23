<?php

namespace phpdk\lang;


use phpdk\io\PrintStream;

/**
 * Class System
 * @package phpdk\lang
 */
class System
{
    public static function init()
    {
        static::setPrintStream(new PrintStream());
    }

    /** @var PrintStream */
    public static $out;


    public static function getPrintStream(): PrintStream
    {
        return static::$out;
    }

    /**
     * @param PrintStream $out
     */
    public static function setPrintStream(PrintStream $out)
    {
        self::$out = $out;
    }
}