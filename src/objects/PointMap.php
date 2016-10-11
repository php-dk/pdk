<?php

namespace ToolsPhp\Types\objects;

use ToolsPhp\Types\exception\TypeException;
use ToolsPhp\Types\interfaces\ToJsonInterface;
use ToolsPhp\Types\interfaces\Type;

/**
 * Класс точка на карте
 * Class PointMap
 *
 * @package components\core
 */
class PointMap implements Type, ToJsonInterface
{
    /** @var float */
    protected $lat;
    /** @var float */
    protected $lng;

    /**
     * PointMap constructor.
     *
     * @param float $lat
     * @param float $lng
     */
    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }


    /**
     * @param PointMap $pointMap
     *
     * @return \Types\objects\PointMap|static
     */
    public function sum(PointMap $pointMap): self
    {
        $lat = $this->getLat() + $pointMap->getLat();
        $lng = $this->getLng() + $pointMap->getLng();

        return new static($lat, $lng);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !$this->getLat() && !$this->getLng();
    }

    /**
     * @param $round
     *
     * @return \Types\objects\PointMap|static
     */
    public function round($round): self
    {
        $lat = (string)$this->getLat();
        $lng = (string)$this->getLng();
        $kef = 1;
        for ($i = 0; $i < $round; $i++) {
            $kef *= 10;
        }

        $lat = (string)(round($lat * $kef) / $kef);
        for ($i = strlen(explode('.', $lat)[1]); $i < $round; $i++) {
            $lat .= '0';
        }

        $lng = (string)(round($lng * $kef) / $kef);
        for ($i = strlen(explode('.', $lng)[1]); $i < $round; $i++) {
            $lng .= '0';
        }

        return new static($lat, $lng);
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat(float $lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     */
    public function setLng(float $lng)
    {
        $this->lng = $lng;
    }

    /**
     * @param $array
     *
     * @return \Types\objects\PointMap|static
     * @throws \Types\objects\MapPointException
     */
    public static function createByArray($array): self
    {
//        if ($array instanceof static) {
//            return new static($array->getLat(), $array->getLng());
//        }

        if (isset($array['lat'], $array['lng'])) {
            return new static($array['lat'], $array['lng']);
        } else if (count($array) === 2) {
            return new static((float)$array[0], (float)$array[1]);
        }

        throw new MapPointException('Не удалось созадать PointMap по массиву');
    }

    public static function new($data): self
    {
        if ($data instanceof static) {
            return new static($data->getLat(), $data->getLng());
        }

        return static::createByArray($data);
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'lat' => (string)$this->getLat(),
            'lng' => (string)$this->getLng()
        ];
    }

    /**
     * @param string $json
     *
     * @return static
     * @throws MapPointException
     */
    public static function createByJson($json)
    {
        $json = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new MapPointException('Ошибка парсинга json: ' . json_last_error_msg());
        }

        if (isset($json['lat'])) {
            return new static((float)$json['lat'], (float)$json['lng']);
        } elseif (isset($json->lat)) {
            return new static((float)$json->lng, (float)$json->lng);
        } else if (is_array($json) && count($json) === 2) {
            return new static((float)$json[0], (float)$json[1]);
        }

        throw new MapPointException('Ошибка парсинга json');
    }


    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}

class MapPointException extends TypeException
{

}