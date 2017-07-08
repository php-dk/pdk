<?php

namespace PDK\tests\unit\lang;

use PDK\lang\TArray;
use PDK\lang\TString;
use PDK\tests\TestCase;

class StringTest extends TestCase
{
    public function testReplace()
    {
        static::assertEquals("12 12", (string)TString::new("12 33")->replace('33', '12'));
    }

    public function testArrayAccess()
    {
        $string = new TString("1");
        static::assertEquals($string[0], '1');

        $string[] = '2';
        static::assertEquals($string, '12');
    }

    public function testSplit()
    {
        $string = new TString("hello world");
        list($hello, $world)  = $string->split(' ');
        static::assertEquals($hello, 'hello');
        static::assertEquals($world, 'world');
    }

    public function testLength()
    {
        $string = new TString("привет");
        static::assertCount(6, $string);
    }

    public function testIterable()
    {
        $string = new TString("12345");
        $sum = 0;
        foreach ($string as $char) {
            $sum += (int)$char;
        }

        static::assertEquals($sum, 15);
    }

    public function testCharArray()
    {
        $string = new TString("123");

        static::assertEquals($string->toCharArray(), new TArray(['1', '2', '3']));
    }

    public function testEquals()
    {
        static::assertSame(TString::new("hello")->equals("hello"), true);
        static::assertSame(TString::new("hello")->equals("hello2"), false);
    }

    public function testFormat()
    {
        static::assertEquals((string)TString::format('0', '1'), '1');
    }

}
