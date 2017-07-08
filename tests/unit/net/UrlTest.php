<?php


use PDK\net\Url;
use PDK\tests\TestCase;

class UrlTest extends TestCase
{
    /**
     *
     */
    public function testParse()
    {
        $url = new Url("http://realtor.im/foo/?gat=12&get2=13#stop");
        static::assertEquals($url->getScheme(), 'http');
        static::assertEquals($url->getHost(), 'realtor.im');
        static::assertEquals($url->getPath(), '/foo/');

        static::assertEquals($url->getQuery(), 'gat=12&get2=13');
        static::assertEquals($url->getQueryArray()->getValue(), ['gat' => 12, 'get2' => 13]);
        static::assertEquals($url->getFragment(), 'stop');

        $url->setQuery(['data'=> 12]);
        static::assertEquals($url->toString(), 'http://realtor.im/foo/?data=12#stop');

        $url->setScheme('https');
        static::assertEquals($url->toString(), 'https://realtor.im/foo/?data=12#stop');

        $url->setPath('/foo/foo2');
        static::assertEquals($url->toString(), 'https://realtor.im/foo/foo2?data=12#stop');

        $url->setFragment('yes');
        static::assertEquals($url->toString(), 'https://realtor.im/foo/foo2?data=12#yes');
    }
    
}
