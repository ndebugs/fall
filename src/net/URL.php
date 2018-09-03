<?php

namespace ndebugs\fall\net;

class URL {
    
    private $scheme;
    private $host;
    private $port;
    private $path;
    private $query;
    
    public function getScheme() {
        return $this->scheme;
    }

    public function setScheme($scheme) {
        $this->scheme = $scheme;
    }

    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getPort() {
        return $this->port;
    }

    public function setPort($port) {
        $this->port = $port;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath(Path $path) {
        $this->path = $path;
    }

    public function getQuery() {
        return $this->query;
    }

    public function setQuery(QueryString $query) {
        $this->query = $query;
    }
    
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
    
    public static function parse($value) {
        $url = new URL();
        $url->setScheme(parse_url($value, PHP_URL_SCHEME));
        $url->setHost(parse_url($value, PHP_URL_HOST));
        $url->setPort(parse_url($value, PHP_URL_PORT));
        
        $pathString = parse_url($value, PHP_URL_PATH);
        $url->setPath(Path::parseURL($pathString));
        
        $url->setQuery(parse_url($value, PHP_URL_QUERY));
        
        return $url;
    }
}
