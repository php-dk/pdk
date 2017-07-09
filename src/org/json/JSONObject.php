<?php

namespace phpdk\org\json;

class JSONObject
{
    protected $json;

    /**
     * JSONObject constructor.
     * @param $json
     */
    public function __construct($json)
    {
        $this->json = $json;
    }


    public function toArray()
    {
        return JSON::decode($this->json, true);
    }

}