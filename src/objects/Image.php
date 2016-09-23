<?php

namespace Types\objects;


use Types\exception\TypeException;
use Types\interfaces\ImageInterface;
use Types\interfaces\ToJsonInterface;
use Types\interfaces\Type;
use Types\JSON;

/**
 * Class Image
 *
 *  - объект описывающий изображение
 *  - перед началом использованния запустить Image::config(['remote' => <staticServer>])
 *     * где staticServer - сервер на котором лежат изображения
 *
 *
 * @package type\objects
 */
class Image implements ToJsonInterface, ImageInterface
{
    /**
     * @var string
     */
    protected $version = '0.1';

    /**
     * @var bool
     */
    protected $isRemote = true;
    private $original_path;

    /**
     * @var string
     */
    protected static $urlRemoteServer = 'http://static.server.com';

    /**
     * @var string
     */
    protected $path;
    protected $ratio;

    /**
     * Image constructor.
     *
     * @param null $url
     * @param bool $isRemote
     */
    public function __construct($url = null, bool $isRemote = false)
    {
        if ($url && !$isRemote) {
            $url = new Url($url);
            if ($url->getSite() === self::$urlRemoteServer) {
                $this->path = $url->getPath();
                $this->isRemote = true;

            } elseif (!$url->getDomain()) {

                $url = new Url(self::$urlRemoteServer . '/' . $url);
                $this->path = $url->getPath();
                $this->isRemote = true;
//                throw new ImageException('Не верный демен изображения');
            } else {
                $url = new Url($url);
                self::$urlRemoteServer = $url->getSite();
                $this->path = $url->getPath();
                $this->isRemote = true;
            }
        } else {
            $this->isRemote = $isRemote;
            $this->path = $url;
        }

        $this->original_path = $this->path;
    }

    public function setRatio($ratio): self
    {
        $this->ratio = $ratio;

        return $this;
    }

    /**
     * @param array $size
     *
     * @return $this
     * @throws \Types\objects\ImageException
     */
    public function setSize(array $size)
    {
        $width = $size[0];
        $height = $size[1];
        $ratio = $this->ratio;

        if (!$width && ($height || $ratio)) {
            throw new ImageException();
        }

        if (!$width && !$height && !$ratio) {
            return $this;
        }

        // '${1}1500x500r1.6/'
        $replacement = '${1}';
        $replacement .= $width;
        if ($height) {
            $replacement .= "x$height";
        }
        if ($ratio) {
            $replacement .= 'r' . number_format($ratio, 1);
        }
        $replacement .= '/';


        $this->path = preg_replace('~^(/st\d+/)~', $replacement, str_replace('//', '/', $this->original_path) ?: '');

        return $this;
    }


    /**
     * @param array $params
     */
    public static function config(array $params)
    {
        static::$urlRemoteServer = $params['remote'] ?? null;
    }

    /**
     * @param $path
     *
     * @return Image
     */
    public static function createRemoteImg($path):self
    {
        $static = new static;
        $static->isRemote = true;
        $static->path = (string)$path;

        return $static;
    }

    /**
     * @param string $path
     *
     * @return Image
     */
    public function createImg(string $path): self
    {
        $static = new static;
        $static->isRemote = false;
        $static->path = (string)$path;

        return $static;
    }

    /**
     * @param $json
     *
     * @return Image
     * @throws \Types\JSONException
     * @throws ImageException
     */
    public function createByJson($json): self
    {
        $data = JSON::decode($json);

        return static::createByArray($data);
    }

    /**
     * @param array $params
     *
     * @return Image
     * @throws ImageException
     */
    public static function createByArray(array $params): self
    {
        $static = new static;

        foreach (['path', 'version', 'isRemove'] as $property) {
//            if (isset($static->{$property})) {
            $static->{$property} = $params[$property] ?? null;
//            } else {
//                throw new ImageException("Не удалось создать изображение по имеющимся данным.
//                Возмложно оно создано не этим объектом, Image::$property");
//            }
        }

        return $static;
    }

    /**
     * @return string
     * @throws \Types\JSONException
     */
    public function toJson(): string
    {
        return JSON::encode($this->toArray());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'version' => $this->version,
            'isRemote' => $this->isRemote,
            'path' => $this->path
        ];
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return str_replace('//', '/', $this->path) ?: '';
    }

    /**
     * @return string
     * @throws ImageException
     */
    public function toString(): string
    {
        if ($this->isRemote) {
            if (!static::$urlRemoteServer) {
                throw new ImageException('Объект для работы с изображениями требует настройки. см. Image::config');
            }

            return static::$urlRemoteServer . $this->getPath();
        }

        return $this->getPath();
    }

    public function __toString()
    {
        try {
            return (string)$this->toString();
        } catch (ImageException $ex) {
            return '';
        }
    }

    public function saveInFile(string $fileName = '')
    {
        $file = file_get_contents($this->toString());
        if (!$fileName) {
            $fileName = str_replace('/', '', $this->getPath());
        }

        $fp = fopen($fileName, 'w');
        fwrite($fp, $file);
        fclose($fp);
    }

}

class ImageException extends TypeException
{

}