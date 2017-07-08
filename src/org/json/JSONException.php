<?php

namespace PDK\org\json;

use PDK\lang\Exception;

class JSONException extends Exception
{
    public function __construct($message, $code = null, $previous = null)
    {
        $message = 'Ошибка парсинга JSON : ' . $message;
        parent::__construct($message, $code, $previous);
    }

}