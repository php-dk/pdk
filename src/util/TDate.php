<?php

namespace phpdk\util;


use phpdk\lang\TObject;
use phpdk\lang\TString;

/**
 * Class Date
 * @package phpdk\util
 * @see https://docs.oracle.com/javase/7/docs/api/java/util/Date.html
 */
class TDate extends TObject
{
    /**
     * @var
     */
    private $year;
    /**
     * @var
     */
    private $month;
    /**
     * @var
     */
    private $date;
    /**
     * @var
     */
    private $hrs;
    /**
     * @var
     */
    private $min;
    /**
     * @var
     */
    private $sec;

    public function __construct($year, $month, $date, $hrs, $min, $sec)
    {
        $this->year = $year;
        $this->month = $month;
        $this->date = $date;
        $this->hrs = $hrs;
        $this->min = $min;
        $this->sec = $sec;
    }

    public static function parse($string): self
    {
        //return new sta
    }

    public function getTime(): int
    {
        return 12;
    }



}