<?php

use Types\JSON;
use Types\JSONException;
use Types\tests\TestCase;

class JsonTest extends TestCase
{
    public function testEncode()
    {
        $data = JSON::encode(['a' => 12]);
        $this->assertEquals($data, json_encode(['a' => 12]));
    }

    public function testDecode()
    {
        $this->assertEquals(JSON::decode('{"a":12}', true), ['a' => 12]);
    }

    public function testDecodeFail()
    {
        $this->setExpectedException(JSONException::class);
        $this->assertEquals(JSON::decode('{"a":12,,}', true), ['a' => 12]);
    }
}
