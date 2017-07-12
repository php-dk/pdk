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
    private $hours;
    /**
     * @var
     */
    private $min;
    /**
     * @var
     */
    private $sec;

    public function __construct($year = null, $month = null, $date = null, $hours = null, $min = null, $sec = null)
    {
        $this->year = $year;
        $this->month = $month;
        $this->date = $date;
        $this->hours = $hours;
        $this->min = $min;
        $this->sec = $sec;
    }


    public function getTime(): int
    {
        return 12;
    }




}