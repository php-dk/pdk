<?php

namespace phpdk\text;


/**
 * Class DateFormat
 * @package phpdk\text
 * @see https://docs.oracle.com/javase/7/docs/api/java/text/DateFormat.html
 */
class DateFormat extends Format
{
    const STYLE_SHORT = 1; //  12.13.52 or 3:30pm
    const STYLE_MEDIUM = 2; // Jan 12, 1952
    const STYLE_LONG = 3; // January 12, 1952 or 3:30:32pm
    const STYLE_FULL = 4; //April 12, 1952 AD or 3:30:42pm PST.

    public function getDateInstance(): self
    {
        return new static();
    }
}