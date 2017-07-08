<?php

namespace ToolsPhp\Types;

use Countable;
use Traversable;
use ToolsPhp\Types\exception\TypeException;
use ToolsPhp\Types\interfaces\ToJsonInterface;
use ToolsPhp\Types\interfaces\Type;

/**
 *
 * Class TString
 *
 * @see:unit-test  housing\tests\types\types\TStringTest.php
 *
 * @package housing\components\types
 */
class TString implements Type, ToJsonInterface, Countable, \IteratorAggregate
{
    /** @var string */
    protected $_text;

    const ENCODING = 'UTF-8';
    const EMPTY = '';
    const SPACE = ' ';


    protected static $TRANS = [
        'А' => "A", "Б" => "B", "В" => "V", "Г" => "G",
        "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
        "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
        "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
        "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
        "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
        "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
        "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
        "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
        "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
        "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
        "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
        "ы" => "yi", "ь" => "'", "э" => "e", "ю" => "yu", "я" => "ya",
        "." => "_", " " => "_", "?" => "_", "/" => "_", "\\" => "_",
        "*" => "_", ":" => "_", "\"" => "_", "<" => "_",
        ">" => "_", "|" => '_'
    ];

    /**
     * TString constructor.
     *
     * @param $text
     */
    public function __construct($text = self::EMPTY)
    {
        $this->_text = (string)$text;
    }


    /**
     * @param $text
     *
     * @return static
     */
    public static function create($text)
    {
        return new static($text);
    }

    /**
     * @param $text
     *
     * @return \Types\TString
     */
    public static function new($text):self
    {
        return new static($text);
    }






    /**
     * @param $pattern
     * @param $replace
     *
     * @return $this
     */
    public function pregReplace($pattern, $replace)
    {
        $this->_text = preg_replace($pattern, $replace, $this->_text);

        return $this;

    }



    /**
     * @return $this
     */
    public function russian()
    {
        $this->_text = strstr($this->_text, static::$TRANS);

        return $this;
    }

    /**
     * @param $glue
     * @param array $data
     *
     * @return mixed
     */
    public static function implodeNotEmpty($glue, array $data)
    {
        return implode($glue, array_filter($data, function ($e) {
            return !$e;
        }));
    }

    /**
     * @param $pattern
     * @param null $param
     *
     * @return array|bool|static
     */
    public function getRegMatchParams($pattern, $param = null)
    {
        $match = [];
        preg_match($pattern, $this->_text, $match);

        if (!$param) {
            return $match;
        }

        if (is_string($param) && isset($match[$param])) {
            return new static($match[$param]);
        }

        return false;

    }

    /**
     * @param $pattern
     *
     * @return array
     */
    public function pregMatchParams($pattern)
    {
        $match = [];
        preg_match($pattern, $this->_text, $match);
        $result = [];

        foreach ($match as $k => $item) {
            if (is_string($k)) {
                $result[] = trim($item);
            }
        }

        return $result;

    }

    /**
     * @param $pattern
     *
     * @return array
     */
    public function getPregMatchAllParams($pattern)
    {
        $match = [];
        preg_match_all($pattern, $this->_text, $match, PREG_SET_ORDER);

        return $match;
    }

    /**
     * @param $pattern
     *
     * @return bool
     */
    public function pregMatch($pattern)
    {
        return preg_match($pattern, $this->_text) === 1;
    }

    /**
     * @return int
     */
    public function length()
    {
        return mb_strlen($this->_text, static::ENCODING);
    }


    /**
     * @param $find
     *
     * @return bool
     */
    public function compare($find)
    {
        return strpos($this->_text, $find) !== false;
    }

    /**
     * @return static
     */
    public function copy()
    {
        return new static($this->_text);
    }

    /**
     * @param $string
     *
     * @return TArray|TString[]
     */
    public function split($string)
    {
        $list = explode($string, $this->_text);

        $array = new TArray([]);
        foreach ($list as $item) {
            $array->append(new static($item));
        }

        return $array;
    }

    /**
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->length();
    }

    /**
     * Retrieve an external iterator
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     *
     * @return string
     */
    public function getIterator()
    {
        for ($i = 0; $i < $this->length(); $i++) {
            yield $this->_text[$i];
        }
    }


    /**
     * @param string $str
     *
     * @return \Types\TString|static
     */
    public function append(string $str): self
    {
        $this->_text .= $str;

        return $this;
    }

    public function appendBack(string $str): self
    {
        $this->_text = $str . $this->_text;

        return $this;
    }

    /**
     * проверяет является ли строка пустой
     *
     *
     * @return bool
     */
    public function isEmpty()
    {
        return strlen($this->_text) === 0;
    }


    /**
     * Возвращает подстроку строки string, начинающейся с start символа по счету и длиной length символов.
     *
     * @param int $start
     * @param int $length
     *
     * @return static
     */
    public function sub($start, $length)
    {
        return new static(mb_substr($this->_text, $start, $length, static::ENCODING));
    }

    /**
     * @param $find
     *
     * @param null $offset
     *
     * @return int
     */
    public function pos($find, $offset = null)
    {
        return mb_strrpos($this->_text, $find, $offset, static::ENCODING);
    }

    /**
     * @param int $length
     *
     * @return static
     */
    public function crop($length)
    {
        if ($this->length() > (int)$length) {
            $substringLimited = $this->sub(0, $length);

            return $substringLimited->sub(0, $substringLimited->pos(' '));
        }

        return $this;
    }

    /**
     * @return static
     */
    public function htmlSpecialChars()
    {
        return new static(htmlspecialchars($this->_text));
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->_text;
    }

    public function __toString()
    {
        return $this->_text;
    }


    public function toJson(): string
    {
        return JSON::encode($this->_text);
    }
}

class TStringException extends TypeException
{
}