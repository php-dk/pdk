<?php
namespace Types;

use Types\exception\TypeException;
use Types\interfaces\Type;

class JSON implements Type
{
    /**
     * @param $json
     *
     * @param bool $isArray - массив или stdClass
     *
     * @return mixed
     * @throws JSONException
     */
    public static function decode($json, $isArray = false)
    {
        $res = json_decode($json, $isArray);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JSONException(json_last_error_msg());
        }

        return $res;
    }

    /**
     * @param $value
     *
     * @return string
     * @throws JSONException
     */
    public static function encode($value)
    {
        $json = json_encode($value);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JSONException(json_last_error_msg());
        }

        return $json;
    }

}

class JSONException extends TypeException
{
    public function __construct($message, $code = null, $previous = null)
    {
        $message = 'Ошибка парсинга JSON : ' . $message;
        parent::__construct($message, $code, $previous);
    }


}