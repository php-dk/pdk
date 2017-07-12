<?php

namespace phpdk\tests\unit\text;

use phpdk\tests\TestCase;
use phpdk\util\TDate;

class DateTest extends TestCase
{
    public function testNowDate()
    {
        $date = new TDate();

        static::assertTrue(true);
    }


}