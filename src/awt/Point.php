<?php

namespace phpdk\awt;

class Point extends Point2D
{
    /** @var  float */
    protected $x;

    /** @var  float */
    protected $y;

    /**
     * Point constructor.
     * @param float|static|null $xOrPoint
     * @param float|null $y
     */
    public function __construct($xOrPoint = null, float $y = null)
    {
        if ($xOrPoint instanceof Point) {
            $this->x = $xOrPoint->getX();
            $this->y = $xOrPoint->getY();
        } elseif (is_numeric($xOrPoint)) {
            $this->x = $xOrPoint;
            $this->y = $y;
        }
    }

    public function equals($object): bool
    {
        if ($object instanceof static) {
            return $this->getX() === $object->getX() && $this->getY() === $object->getY();
        }

        return false;
    }

    public function getX(): ?float
    {
        return $this->x;
    }

    public function getY(): ?float
    {
        return $this->y;
    }

    public function translate(float $dx, float $dy): void
    {
        $this->x += $dx;
        $this->y += $dy;
    }
}