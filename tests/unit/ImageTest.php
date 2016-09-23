<?php

use Types\tests\TestCase;

class ImageTest extends TestCase
{
    public function testCreate()
    {
        $img = Types\objects\Image::createByArray(['path' => '/st1/fff.jpg']);
    }

    public function testCreateImg()
    {
        $img = new \Types\objects\Image('http://static.realtor.im/st1/zgljamvj/1469011150578f54ce3a808.png');
        static::assertEquals('http://static.realtor.im/st1/zgljamvj/1469011150578f54ce3a808.png', (string)$img);
    }

    public function testSize()
    {
        $img = new \Types\objects\Image('http://static.realtor.im/st1/1.png');
        $img->setSize([50,50]);
        static::assertEquals('http://static.realtor.im/st1/50x50/1.png', (string)$img);

        $img->setSize([60,60]);
        static::assertEquals('http://static.realtor.im/st1/60x60/1.png', (string)$img);
    }

//    public function testSaveImg()
//    {
//        $img = new \Types\objects\Image('http://static.moydom.ru/146304071457343aca904ef.jpg');
//        $img->saveInFile();
//    }
}
