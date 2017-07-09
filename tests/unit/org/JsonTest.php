<?php


use phpdk\org\json\JSON;
use phpdk\org\json\JSONException;
use phpdk\tests\TestCase;

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
        $this->expectException(JSONException::class);
        $this->assertEquals(JSON::decode('{"a":12,,}', true), ['a' => 12]);
    }
}
