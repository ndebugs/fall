<?php

namespace ndebugs\fall\http;

use ndebugs\fall\io\InputStream;
use ndebugs\fall\net\URL;

class HTTPRequest extends HTTPMessage {
    
    private $method;
    private $url;
    private $version;
    private $headers;
    private $content;
    
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

    public function getContentType() {
        return $this->getHeader(self::HEADER_CONTENT_TYPE);
    }
    
    public function setHeader($key, $value) {
        if ($this->headers === null) {
            $this->headers = [$key => $value];
        } else {
            $this->headers[$key] = $value;
        }
    }
    
    public function getHeaders() {
        return $this->headers;
    }

    public function setHeaders(array $headers) {
        $this->headers = $headers;
    }
    
    public function getContent() {
        return $this->content;
    }

    public function setContent(InputStream $content = null) {
        $this->content = $content;
    }
}
