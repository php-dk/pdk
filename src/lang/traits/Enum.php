<?php

namespace PDK\lang\traits;

use ArrayIterator;
use ReflectionClass;

trait Enum
{
    private static $_reflection;

    private static function getReflection()
    {
        if (!self::$_reflection) {
            self::$_reflection = new ReflectionClass(get_called_class());
        }

        return self::$_reflection;
    }

    public static function getConstants()
    {
        return self::getReflection()->getConstants();
    }

    public static function getConstName($const)
    {
        foreach (self::getConstants() as $name => $value) {
            if ($value === $const) {
                return $name;
            }
        }

        throw new EnumException('Константа с таким значением не найдена');
    }

    public static function getValueByName(string $constName)
    {
        $constName = strtoupper($constName);

        foreach (self::getConstants() as $name => $value) {
            if ($name === $constName) {
                return $value;
            }
        }

        throw new EnumException('Константа с таким значением не найдена');
    }

    public function getIterator()
    {
        return new ArrayIterator(self::getConstants());
    }
}