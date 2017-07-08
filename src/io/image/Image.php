<?php

namespace PDK\io\image;

use PDK\lang\TObject;
use PDK\lang\TString;
use PDK\net\Url;
use PDK\org\json\JSON;
use PDK\org\json\JSONException;

class Image extends TObject
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
    protected static $urlRemoteServer = 'http://example.ru';

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
     *
     * @internal use Image::new($url, $isRemote)
     */
    public function __construct($url = null, bool $isRemote = true)
    {
        if ($url) {
            $url = new Url($url);
            $isRemote = $url->getSite() === self::$urlRemoteServer ?: $isRemote;
            $this->isRemote = $isRemote;
            $this->path = $url->getPath() ?: $url->getHost();

            $this->original_path = $this->path;
        } else {
            $this->isRemote = false;
            $this->path = '';
        }
    }

    public static function new(string $url = null, bool $isRemote = true): self
    {
        return new static($url, $isRemote);
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
     * @throws ImageException
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

    public function isRemote()
    {
        return $this->isRemote;
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
     * @throws JSONException
     * @throws ImageException
     */
    public static function createByJson($json): self
    {
        $data = JSON::decode($json, true);

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

        foreach (['path', 'version', 'isRemote'] as $property) {
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
     * @throws JSONException
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
        return $this->path ?: '';
    }


    /**
     * @return TString
     * @throws ImageException
     */
    public function toString(): TString
    {
        if ($this->isRemote) {
            if (!static::$urlRemoteServer) {
                throw new ImageException('Объект для работы с изображениями требует настройки. см. Image::config');
            }

            return new TString(static::$urlRemoteServer . $this->getPath());
        }

        return new TString($this->getPath());
    }


}