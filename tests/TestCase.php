<?php

namespace phpdk\tests;

use phpdk\Pdk;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        Pdk::initialization();
    }

}