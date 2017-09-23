<?php


/**
 * Created by PhpStorm.
 * User: dima
 * Date: 23.09.17
 * Time: 23:32
 */
class PrintTest extends \phpdk\tests\TestCase
{
    public function testPrint()
    {
        \phpdk\lang\System::$out::start();
        \phpdk\lang\System::$out::println('hello word');
        $e = \phpdk\lang\System::$out::stop();
        $this->assertEquals($e, 'hello word' . PHP_EOL);
    }
}