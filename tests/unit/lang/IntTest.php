<?php

namespace PDK\tests\unit\lang;

use PDK\lang\TInt;
use PDK\lang\TString;
use PDK\tests\TestCase;

class IntTest extends TestCase
{
    public function testIntEquals()
    {
        $int = new TInt(1);
        static::assertTrue($int->equals(1));
        static::assertTrue($int->equals(new TInt(1)));
        static::assertFalse($int->equals(new TString('1')));
        static::assertFalse($int->equals('1'));
    }

    public function testIntToString()
    {
        $int = new TInt(1);
        static::assertEquals('1', (string)$int);
    }

    public function testIntSum()
    {
        $int = new TInt(1);
        $int = $int->add(1);
        static::assertEquals('2', (string)$int);
    }

}