<?php

namespace PDK\net;

use PDK\lang\TArray;
use PDK\lang\TString;

class Url
{
    /**
     * @var string|false http | https
     */
    protected $scheme = false;
    /**
     * @var string|false  realtor.im
     */
    protected $host = false;
    /**
     * @var string|false /foot/foot1
     */
    protected $path = false;
    /**
     * @var string|false #
     */
    protected $fragment = false;
    /**
     * @var string|false get
     */
    protected $query = false;

    /**
     * Url constructor.
     *
     * @param $url
     */
    public function __construct($url)
    {
        if ((strpos($url, 'http') === false) && parse_url("http://$url")) {
            $url = 'http://' . $url;
        }

        foreach (parse_url($url) as $name => $value) {
            $this->{$name} = $value;
        };

    }

    public static function create($url)
    {
        if (is_string($url)) {
            return new static($url);
        } elseif ($url instanceof static) {
            return $url;
        }

        return false;
    }

    public function toString(): TString
    {
        $str = '';
        if ($this->getScheme()) {
            $str = $this->getScheme() . '://';
        }

        if ($this->getHost()) {
            $str .= $this->getHost();
        }

        if ($this->getPath()) {
            $str .= $this->getPath();
        }

        if ($this->getQuery()) {
            $str .= '?' . $this->getQuery();
        }

        if ($this->getFragment()) {
            $str .= '#' . $this->getFragment();
        }

        return new TString($str);
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    public function setScheme($scheme): self
    {
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }


    public function setHost($host): self
    {
        $host = new static((string)$host);

        if ($host->getHost()) {
            $this->host = $host->getHost();
        }

        if ($host->getScheme()) {
            $this->setScheme($host->getScheme());
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path ?: '';
    }

    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    public function setFragment($fragment): self
    {
        $this->fragment = $fragment;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    public function getQueryArray()
    {
        $res = [];
        foreach (explode('&', $this->getQuery()) as $item) {
            if (count($param = explode('=', $item)) == 2) {
                [$key, $value] = explode('=', $item);
                $res[$key] = $value;
            }
        }

        return new TArray($res);
    }

    /**
     * @param iterable|string $query
     *
     * @return Url
     */
    public function setQuery($query): self
    {
        if (is_iterable($query)) {
            $this->query = '';
            $values = [];
            foreach ($query as $key => $value) {
                $values[] = "$key=$value";
            }

            $this->query = implode('&', $values);
        } elseif (is_string($query)) {
            $this->query = $query;
        }

        return $this;
    }

    /**
     * @return string|false
     */
    public function getSite()
    {
        $site = '';
        if ($this->getScheme()) {
            $site = $this->getScheme() . '://';
        }

        if ($site && $this->getHost()) {
            return $site . $this->getHost();
        }

        return false;
    }

    public function getDomain()
    {
        return $this->getSite();
    }
}