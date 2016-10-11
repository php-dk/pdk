<?php

use ToolsPhp\Types\tests\TestCase;
use ToolsPhp\Types\TString;
use ToolsPhp\Types\TStringException;

class StringTest extends TestCase
{
    public function testReplace()
    {
        static::assertEquals("12 12", (string)TString::create("12 33")->replace('33', '12'));
        
    }


    public function testAll()
    {
        $string = new TString("hello world");
        list($hello, $world)  = $string->split(' ');
        static::assertEquals("$hello $world", $string->toString());

        $string = new TString("привет");
        static::assertCount(6, $string);

        $string = new TString("12345");
        $sum = 0;
        foreach ($string as $char) {
            $sum += (int)$char;
        }
        static::assertEquals($sum, 15);

        static::assertSame(TString::create("hello word")->compare("hello"), true);
        static::assertSame(TString::create("hello word")->compare("hello2"), false);
    }

    public function testFormat()
    {
        $str = (string)TString::new('{p1}{p2}{p3}')->format(['p1'=>'Hello', 'p2'=>' ', 'p3'=>'World']);
        static::assertEquals($str, 'Hello World');
    }
    public function testFormatCaseKey()
    {
        $str = (string)TString::new('{userKey}')->format(['userKey'=>'Hello']);
        static::assertEquals($str, 'Hello');
    }

    public function testFormatKeyInt()
    {
        $str = (string)TString::new('{0}{1}{2}')->format(['Hello', ' ', 'World']);
        static::assertEquals($str, 'Hello World');
    }
    public function testFormatFailed()
    {
        $this->setExpectedException(TStringException::class);
        $str = (string)TString::new('{p1}{p2}{p3}')->format(['p1'=>'Hello', 'p2'=>' ']);
        static::assertEquals($str, 'Hello World');
    }


}
