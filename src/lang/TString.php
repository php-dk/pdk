<?php

namespace phpdk\lang;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use phpdk\lang\exceptions\IndexOutOfBoundsException;
use Traversable;

/**
 * Class TString
 * @package phpdk\lang
 * @see https://docs.oracle.com/javase/6/docs/api/java/lang/String.html
 */
class TString extends AbstractScalar implements
    IteratorAggregate,
    Countable,
    ArrayAccess,
    ScalarInterface
{
    /** @var  string */
    protected $string;

    const ENCODING = 'UTF-8';
    const EMPTY = '';
    const SPACE = ' ';

    /**
     * TString constructor.
     * @param string $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    public static function new($object): self
    {
        return new static($object);
    }

    public function charAt(int $index): string
    {
        if (!isset($this->string)) {
            throw new IndexOutOfBoundsException;
        }

        return $this->string[$index];
    }

    public function equals($object): bool
    {
        return $this->string === (string)$object;
    }


    /**
     * s[0]*31^(n-1) + s[1]*31^(n-2) + ... + s[n-1]
     *
     * @return int
     */
    public function hashCode(): int
    {
        return 1;
    }

    /**
     * Возвращает подстроку строки string, начинающейся с start символа по счету и длиной length символов.
     *
     * @param int $start
     * @param int $length
     *
     * @return static
     */
    public function substring($start, $length = null)
    {
        return new static(mb_substr($this->string, $start, $length, static::ENCODING));
    }


    public function concat($str): self
    {
        return new static($this->string . $str);
    }


    /**
     * @param $search
     * @param $replace
     *
     * @return $this
     */
    public function replace(string $search, string $replace)
    {
        return new static(str_replace($search, $replace, $this->string));
    }


    /**
     * @param $pattern
     *
     * @return bool
     */
    public function matches($pattern): bool
    {
        return preg_match($pattern, $this->string) === 1;
    }

    public function contains(string $contains): bool
    {
        return strpos($this->string, $contains) !== false;
    }

    /**
     * @todo --
     *
     * @param $regex
     * @param $replacement
     * @return TString
     */
    public function replaceFist($regex, $replacement): self
    {
        return new static($this->string);
    }

    /**
     * @todo --
     *
     * @param $regex
     * @param $replacement
     * @return TString
     */
    public function replaceAll($regex, $replacement): self
    {
        return new static($this->string);
    }

    /**
     * @param string $regex
     *
     * @param int|null $limit
     * @return iterable|TString[]
     */
    public function split(string $regex, int $limit = null): iterable
    {
        $list = mbsplit($regex, $this->string);

        $array = [];
        foreach ($list as $item) {
            $array[] = new static($item);
        }

        return $array;
    }


    /**
     * @return static
     */
    public function toLowerCase()
    {
        return new static(mb_strtolower($this->string));
    }

    /**
     * @return static
     */
    public function toUpperCase()
    {
        return new static(mb_strtoupper($this->string));
    }

    /**
     * @return static
     */
    public function trim()
    {
        return new static(trim($this->string));
    }

    public function toCharArray(): TArray
    {
        $chars = new TArray();
        foreach ($this as $char) {
            $chars[] = $char;
        }

        return $chars;
    }

    /**
     * @see https://docs.oracle.com/javase/6/docs/api/java/util/Formatter.html#syntax
     *
     * @param $string
     * @param array ...$args
     * @return TString
     */
    public static function format($string, ...$args): TString
    {
        return new static(strtr($string, $args));
    }

    public function length(): int
    {
        return mb_strlen($this->string);
    }


    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        for ($i = 0; $i < $this->length(); $i++) {
            yield $this->string[$i];
        }
    }


    public function toString(): TString
    {
        return new TString($this->string);
    }

    public function __toString()
    {
        return (string)$this->string;
    }

    public function count()
    {
        return $this->length();
    }

    public function offsetExists($offset)
    {
        return isset($this->string[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->toCharArray()[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->string .= $value;
        } else {
            $this->string[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->string[$offset]);
    }

    public function getValue(): string
    {
        return $this->string;
    }

    public static function instanceof ($object): bool
    {
        return is_string($object) || $object instanceof static;
    }


}