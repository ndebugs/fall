<?php

namespace ndebugs\fall\http;

use ndebugs\fall\io\InputStream;
use ndebugs\fall\net\Path;
use ndebugs\fall\net\QueryString;
use ndebugs\fall\net\URL;

class HTTPRequestBuilder {
    
    /** @var string */
    private $method;
    
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
    
    /** @var string */
    private $version;
    
    /** @var string[] */
    private $headers = [];
    
    /** @var InputStream */
    private $content;
    
    /**
     * @param string $method
     * @return HTTPRequestBuilder
     */
    public function setMethod($method) {
        $this->method = $method;
        
        return $this;
    }
    
    /**
     * @param string $scheme
     * @return HTTPRequestBuilder
     */
    public function setScheme($scheme) {
        $this->scheme = $scheme;
        
        return $this;
    }

    /**
     * @param string $host
     * @return HTTPRequestBuilder
     */
    public function setHost($host) {
        $this->host = $host;
        
        return $this;
    }

    /**
     * @param integer $port
     * @return HTTPRequestBuilder
     */
    public function setPort($port) {
        $this->port = $port;
        
        return $this;
    }
    
    /**
     * @param string $uri
     * @return HTTPRequestBuilder
     */
    public function setURI($uri) {
        $pathString = parse_url($uri, PHP_URL_PATH);
        $this->path = Path::parseURL($pathString);
        
        $queryString = parse_url($uri, PHP_URL_QUERY);
        if ($queryString) {
            $this->query = QueryString::parse($queryString);
        }
        
        return $this;
    }

    /**
     * @param string $version
     * @return HTTPRequestBuilder
     */
    public function setVersion($version) {
        $this->version = $version;
        
        return $this;
    }
    
    /**
     * @param string $key
     * @param string $value
     * @return HTTPRequestBuilder
     */
    public function addHeader($key, $value) {
        $this->headers[$key] = $value;
        
        return $this;
    }
    
    /**
     * @param InputStream $content
     * @return HTTPRequestBuilder
     */
    public function setContent(InputStream $content) {
        $this->content = $content;
        
        return $this;
    }
    
    /** @return HTTPRequest */
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
