<?php

namespace phpdk\lang;

interface ScalarInterface
{
    /**
     * @return int|string|float|array
     */
    public function getValue();


}