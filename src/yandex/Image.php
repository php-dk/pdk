<?php

namespace Types\yandex;


use Types\interfaces\ImageInterface;
use Types\objects\PointMap;

class Image implements ImageInterface
{
    protected $point;
    protected $zoom;
    protected $size = [300, 300];


    /**
     * Image constructor.
     *
     * @param $point
     */
    public function __construct(PointMap $point)
    {
        $this->point = $point;
    }

    /**
     * @param mixed $zoom
     *
     * @return \Types\yandex\Image|static
     */
    public function setZoom(int $zoom): self
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * @param array [x, y] $size
     *
     * @return \Types\yandex\Image
     */
    public function setSize(array $size)
    {
        $this->size = $size;

        return $this;
    }

    public function toString(): string
    {
        return $this->getUrl();
    }


    public function __toString()
    {
        try {
            return (string)$this->toString();
        } catch (\Exception $ex) {
            return '';
        }
    }

    public function getUrl(): string
    {
        $p = $this->point;
        $s = $this->size;

        return "https://static-maps.yandex.ru/1.x/?ll={$p->getLng()},{$p->getLat()}&z=17&size={$s[0]},$s[1]&l=map";
    }

}