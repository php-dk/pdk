<?php


use phpdk\io\image\Image;
use phpdk\tests\TestCase;

class ImageTest extends TestCase
{
    public function testCreateImg()
    {
        $img = new Image('http://example.ru/st1/zgljamvj/1469011150578f54ce3a808.png');
        static::assertEquals('http://example.ru/st1/zgljamvj/1469011150578f54ce3a808.png', (string)$img);
    }

    public function testSize()
    {
        $img = new Image('http://example.ru/st1/1.png');
        $img->setSize([50,50]);
        static::assertEquals('http://example.ru/st1/50x50/1.png', (string)$img);

        $img->setSize([60,60]);
        static::assertEquals('http://example.ru/st1/60x60/1.png', (string)$img);
    }

//    public function testSaveImg()
//    {
//        $img = new \Types\objects\Image('http://static.moydom.ru/146304071457343aca904ef.jpg');
//        $img->saveInFile();
//    }
}
