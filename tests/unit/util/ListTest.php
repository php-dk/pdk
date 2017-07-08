<?php

namespace PDK\tests\unit\util;

use PDK\lang\TInt;
use PDK\lang\TString;
use PDK\util\AbstractCollection;
use PDK\util\TList;
use PDK\tests\mock\TestClassA as AL;

class ListTest extends AbstractCollectionTest
{

    public function buildCollection(...$args): AbstractCollection
    {
        return new TList(...$args);
    }

    public function testAddElement()
    {
        $list = new TList(AL::class);
        $list->add(0, new AL(0));
        $list->add(1, new AL(1));
        $list->add(new AL(2));

        static::assertEquals(3, $list->count());
        static::assertEquals($list->get(2)->i,  2);
    }

    public function testAddIntScalarElement()
    {
        $list = new TList(TInt::class);
        $list->add(new TInt(0));
        $list->add(1);
        $list->add(2);

        static::assertEquals(3, $list->count());
        static::assertEquals($list->get(2)->getValue(),  2);
    }

    public function testAddStringScalarElement()
    {
        $list = new TList(TString::class);
        $list->add(new TString("zero"));
        $list->add("first");
        $list->add("three");

        static::assertEquals(3, $list->count());
        static::assertEquals((string)$list->get(2),  "three");
        foreach ($list as $string) {
            static::assertInstanceOf(TString::class, $string);
        }
    }

    public function testListStringContains()
    {
        $list = new TList(TString::class);
        $list->add(new TString("zero"));
        $list->add("first");
        $list->add("three");

        static::assertTrue($list->contains("first"));
        static::assertTrue($list->contains(new TString("first")));

        static::assertFalse($list->contains(new TString("aa")));
        static::assertFalse($list->contains("aa"));
    }

    public function testListIntContains()
    {
        $list = new TList(TInt::class);
        $list->add(new TInt(0));
        $list->add(1);

        static::assertTrue($list->contains(1));
        static::assertTrue($list->contains(new TInt(1)));

        static::assertFalse($list->contains(new TInt(22)));
        static::assertFalse($list->contains(22));
    }

    public function testFailedAddStringInIntListElement()
    {
        $this->expectException(\PDK\lang\Exception::class);
        $list = new TList(TInt::class);
        $list->add(new TString("zero"));
    }


}