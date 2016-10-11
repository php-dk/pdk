<?php

use ToolsPhp\Types\TArray;
use ToolsPhp\Types\tests\TestCase;
use ToolsPhp\Types\TIntArray;
use ToolsPhp\Types\collections\TCollection;

class ArrayTest extends TestCase
{
    public function testAll()
    {
        $array = new TArray([1, 2, 3]);
        static::assertEquals($array->map(function ($i) {
            return $i + 1;
        })->toArray(), [2, 3, 4]);

        $array = new TArray([1, 2, 3]);
        static::assertEquals($array->filter(function ($i) {
            return $i > 1;
        })->values()->toArray(), [2, 3]);
    }

    public function testIsArray()
    {
        $array = new TArray();
        static::assertTrue(TArray::isArray($array));

        $array = new TCollection();
        static::assertTrue(TArray::isArray($array));

        $array = [];
        static::assertTrue(TArray::isArray($array));

        $array = (function () {
            yield 1;
            yield 2;
            yield 3;
        })();

        static::assertTrue(TArray::isArray($array));

    }
    public function testInit()
    {
        $data = ['title' => 12, 'name' => 'dima'];

        list($title, $name) = (new TArray($data))['title, name'];

        $this->assertEquals($title, 12);
        $this->assertEquals($name, 'dima');
    }

    public function testEmpty()
    {
        static::assertEquals(0, count([]));
        static::assertEquals(0, count(new TArray));
    }

    public function testCreate()
    {
        $array = new TArray([1, 2, 3]);
        $array2 = new TArray($array);
        $this->assertEquals($array2->toArray(), [1, 2, 3]);
    }

    public function testGetPropertyValuestArray()
    {
        $obj1 = new \stdClass();
        $obj1->foo = 12;

        $obj2 = new \stdClass();
        $obj2->foo = 13;

        $mas = [$obj1, $obj2];

        $array = new TArray($mas);
        $this->assertEquals($array->getArrayValuesProperty('foo')->toArray(), [12, 13]);
    }

    public function testCreateAndMerge()
    {
        $array = new TArray([1]);

        foreach ($array as $item) {
            static::assertSame($item, 1);
        }

        $array->merge([2]);
        static::assertEquals($array->toArray(), [1, 2]);

    }

    public function testIterator()
    {
        $iter = new \ArrayIterator([1, 2]);
        $array = new TArray([3]);
        $array->merge($iter);
        static::assertEquals($array->toArray(), [3, 1, 2]);
        $array->merge(new \ArrayIterator([4]));
        static::assertEquals($array->toArray(), [3, 1, 2, 4]);
        static::assertCount(4, $array);

        $array->append([5]);
        static::assertEquals($array->toArray(), [3, 1, 2, 4, [5]]);
        static::assertCount(5, $array);
    }

    public function testUnique()
    {
        $res = TArray::new([1, 2, 3, 3, 3])->unique()->toArray();
        static::assertEquals($res, [1, 2, 3]);
    }

    public function testIntArray()
    {
        $array = TIntArray::new([1, 2, 3, 'ffdf', 'ffdf'])->unique();
        $sum = 0;
        foreach ($array as $value) {
            static::assertTrue(is_integer($value));
            $sum += $value;
        }
        self::assertEquals([1, 2, 3, 0], $array->toArray());
        self::assertEquals(4, $array->count());
        self::assertEquals(6, $sum);
    }


}