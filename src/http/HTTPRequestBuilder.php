<?php

namespace ndebugs\fall\http;

use ndebugs\fall\io\InputStream;
use ndebugs\fall\net\Path;
use ndebugs\fall\net\QueryString;
use ndebugs\fall\net\URL;

class HTTPRequestBuilder {
    
    private $method;
    private $scheme;
    private $host;
    private $port;
    private $path;
    private $query;
    private $version;
    private $headers = [];
    private $content;
    
    public function setMethod($method) {
        $this->method = $method;
        
        return $this;
    }
    
    public function setScheme($scheme) {
        $this->scheme = $scheme;
        
        return $this;
    }

    public function setHost($host) {
        $this->host = $host;
        
        return $this;
    }

    public function setPort($port) {
        $this->port = $port;
        
        return $this;
    }
    
    public function setURI($uri) {
        $pathString = parse_url($uri, PHP_URL_PATH);
        $this->path = Path::parseURL($pathString);
        
        $queryString = parse_url($uri, PHP_URL_QUERY);
        if ($queryString) {
            $this->query = QueryString::parse($queryString);
        }
        
        return $this;
    }

    public function setVersion($version) {
        $this->version = $version;
        
        return $this;
    }
    
    public function addHeader($key, $value) {
        $this->headers[$key] = $value;
        
        return $this;
    }
    
    public function setContent(InputStream $content) {
        $this->content = $content;
        
        return $this;
    }
    
    public function build() {
        $request = new HTTPRequest();
        $request->setMethod($this->method);
        
        $url = new URL();
        $url->setScheme($this->scheme);
        $url->setHost($this->host);
        $url->setPort($this->port);
        $url->setPath($this->path);
        $url->setQuery($this->query);
        $request->setURL($url);
        
        $request->setVersion($this->version);
        $request->setHeaders($this->headers);
        $request->setContent($this->content);
        
        return $request;
    }
}