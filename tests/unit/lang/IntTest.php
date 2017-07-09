<?php

namespace phpdk\tests\unit\lang;

use phpdk\lang\TInt;
use phpdk\lang\TString;
use phpdk\tests\TestCase;

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


    public function testIntLarge()
    {
        $int = new TInt('1234567891234567812345678');
        static::assertTrue($int->equals($int));
        static::assertEquals($int->getValue(), TInt::MAX);
    }

    public function testIntCompare()
    {
        $int = new TInt(5);

        static::assertTrue($int->equals(5));
        static::assertTrue($int->less(6));
        static::assertTrue($int->lessEquals(5));
        static::assertTrue($int->more(4));
        static::assertTrue($int->moreEquals(5));

        static::assertTrue($int->equals(new TInt(5)));
        static::assertTrue($int->less(new TInt(6)));
        static::assertTrue($int->lessEquals(new TInt(5)));
        static::assertTrue($int->more(new TInt(4)));
        static::assertTrue($int->moreEquals(new TInt(5)));

        static::assertFalse($int->equals('5'));
        static::assertFalse($int->equals(new TString('5')));
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

        $int = $int->add(new TInt(2));
        static::assertEquals('4', (string)$int);
    }

}