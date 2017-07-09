<?php


use phpdk\tests\TestCase;

class TestEnum extends  \phpdk\lang\TEnum
{
    const CONST_1 = 1;
    const CONST_2 = 2;
}

class EnumTest extends TestCase
{
    public function testGetConstName()
    {
        $this->assertEquals('CONST_1', TestEnum::getConstName(TestEnum::CONST_1));
    }

    public function testGetConstValue()
    {
        $this->assertEquals(1, TestEnum::getValueByName('CONST_1'));
    }
    
    public function testGetConstValueUpCase()
    {
        $this->assertEquals(1, TestEnum::getValueByName('const_1'));
    }

    public function testConstIterator()
    {
        $names = [];
        foreach (new TestEnum() as $name => $value) {
            $names[] = $name;
        }

        $this->assertEquals(['CONST_1', 'CONST_2'], $names);
    }


}
