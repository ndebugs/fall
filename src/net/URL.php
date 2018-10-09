<?php

namespace ndebugs\fall\net;

class URL {
    
    /** @var string */
    private $scheme;
    
    /** @var string */
    private $host;
    
    /** @var integer */
    private $port;
    
    /** @var Path */
    private $path;
    
    /** @var QueryString */
    private $query;
    
    /** @return string */
    public function getScheme() {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return void
     */
    public function setScheme($scheme) {
        $this->scheme = $scheme;
    }

    /** @return string */
    public function getHost() {
        return $this->host;
    }

    /**
     * @param string $host
     * @return void
     */
    public function setHost($host) {
        $this->host = $host;
    }

    /** @return integer */
    public function getPort() {
        return $this->port;
    }

    /**
     * @param integer $port
     * @return void
     */
    public function setPort($port) {
        $this->port = $port;
    }

    /** @return Path */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param Path $path
     * @return void
     */
    public function setPath(Path $path) {
        $this->path = $path;
    }

    /** @return QueryString */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @param QueryString $query [optional]
     * @return void
     */
    public function setQuery(QueryString $query = null) {
        $this->query = $query;
    }
    
    /** @return string */
    public function __toString() {
        $value = '';
        if ($this->scheme) {
            $value .= $this->scheme . '://';
        }
        $value .= $this->host;
        if ($this->port) {
            $value .= ':' . $this->port;
        }
        $value .= $this->path;
        if ($this->query) {
            $value .= '?' . $this->query;
        }
        return $value;
    }
    
    /**
     * @param string $value
     * @return URL
     */
    public static function parse($value) {
        $url = new URL();
        $url->setScheme(parse_url($value, PHP_URL_SCHEME));
        $url->setHost(parse_url($value, PHP_URL_HOST));
        $url->setPort(parse_url($value, PHP_URL_PORT));
        
        $pathString = parse_url($value, PHP_URL_PATH);
        $url->setPath(Path::parseURL($pathString));
        
        $queryString = parse_url($value, PHP_URL_QUERY);
        if ($queryString) {
            $url->setQuery(QueryString::parse($queryString));
        }
        
        return $url;
    }
}
