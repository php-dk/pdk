<?php

use phpdk\lang\TArray;
use phpdk\tests\TestCase;
use phpdk\util\AbstractCollection;

class ArrayTest extends TestCase
{
    public function testAll()
    {
        $array = new TArray([1, 2, 3]);
        $newArray = $array->map(function ($i) {
            return $i + 1;
        });
        static::assertEquals($newArray->getValue(), [2, 3, 4]);

        $array = new TArray([1, 2, 3]);
        static::assertEquals($array->filter(function ($i) {
            return $i > 1;
        })->getValue(), [2, 3]);
    }

    public function testIsArray()
    {
        $array = new TArray();
        static::assertTrue(TArray::isIterable($array));

        $array = new \phpdk\util\TList();
        static::assertTrue(TArray::isIterable($array));

        $array = [];
        static::assertTrue(TArray::isIterable($array));

        $array = (function () {
            yield 1;
            yield 2;
            yield 3;
        })();

        static::assertTrue(TArray::isIterable($array));
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
        $this->assertEquals($array2->getValue(), [1, 2, 3]);
    }



    public function testCreateAndMerge()
    {
        $array = new TArray([1]);

        foreach ($array as $item) {
            static::assertSame($item, 1);
        }

        $array = $array->merge([2]);
        static::assertEquals($array->getValue(), [1, 2]);
    }

    public function testIterator()
    {
        $iter = new ArrayIterator([1, 2]);
        $array = new TArray([3]);
        $array = $array->merge($iter);
        static::assertEquals($array->getValue(), [3, 1, 2]);
        $array = $array->merge(new ArrayIterator([4]));
        static::assertEquals($array->getValue(), [3, 1, 2, 4]);
        static::assertCount(4, $array);

        $array = $array->add([5]);
        static::assertEquals($array->getValue(), [3, 1, 2, 4, [5]]);
        static::assertCount(5, $array);
    }

    public function testUnique()
    {
        $res = TArray::new([1, 2, 3, 3, 3])->unique()->getValue();
        static::assertEquals($res, [1, 2, 3]);
    }
}