<?php

namespace phpdk\org\json;

use phpdk\lang\TObject;

class JSONObject extends TObject
{
    protected $array;

    /**
     * JSONObject constructor.
     * @param $json
     */
    public function __construct($json)
    {
        $this->array = JSON::decode($json, true);
    }


    public function toArray()
    {
        return $this->array;
    }

}