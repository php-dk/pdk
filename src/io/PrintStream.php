<?php

namespace phpdk\io;

class PrintStream
{
    public static function start(): void
    {
        ob_start();
    }

    public static function println($msg): void
    {
        static::print($msg . PHP_EOL);
    }

    public function print($msg): void
    {
        echo $msg;
    }

    public static function stop(): string
    {
        return ob_get_clean();
    }
}