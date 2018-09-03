<?php

namespace ndebugs\fall\net;

use ndebugs\fall\io\FileInputStream;
use ndebugs\fall\net\URL;

class HTTPRequest {
    
    private $method;
    private $url;
    private $version;
    private $headers;
    private $body;
    
    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getURL() {
        return $this->url;
    }

    public function setURL(URL $url) {
        $this->url = $url;
    }
    
    public function getVersion() {
        return $this->version;
    }

    public function setVersion($version) {
        $this->version = $version;
    }

    public function getHeader($key) {
        $uKey = strtoupper($key);
        return isset($this->headers[$uKey]) ? $this->headers[$uKey] : null;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function setHeaders($headers) {
        $this->headers = $headers;
    }
    
    public function getBody() {
        return $this->body;
    }

    public function setBody(FileInputStream $body = null) {
        $this->body = $body;
    }
}
