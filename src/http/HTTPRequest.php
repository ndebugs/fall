<?php

namespace ndebugs\fall\http;

use ndebugs\fall\io\InputStream;
use ndebugs\fall\net\URL;

class HTTPRequest extends HTTPMessage {
    
    /** @var string */
    private $method;
    
    /** @var URL */
    private $url;
    
    /** @var string */
    private $version;
    
    /** @var string[] */
    private $headers;
    
    /** @var InputStream */
    private $content;
    
    /** @return string */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param string $method
     * @return void
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /** @return URL */
    public function getURL() {
        return $this->url;
    }

    /**
     * @param URL $url
     * @return void
     */
    public function setURL(URL $url) {
        $this->url = $url;
    }
    
    /** @return string */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param string $version
     * @return void
     */
    public function setVersion($version) {
        $this->version = $version;
    }

    /** @return string */
    public function getHeader($key) {
        $uKey = strtoupper($key);
        return isset($this->headers[$uKey]) ? $this->headers[$uKey] : null;
    }

    /** @return string */
    public function getContentType() {
        return $this->getHeader(self::HEADER_CONTENT_TYPE);
    }
    
    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setHeader($key, $value) {
        if ($this->headers === null) {
            $this->headers = [$key => $value];
        } else {
            $this->headers[$key] = $value;
        }
    }
    
    /** @return string[] */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @param string[] $headers
     * @return void
     */
    public function setHeaders(array $headers) {
        $this->headers = $headers;
    }
    
    /** @return InputStream */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param InputStream $content [optional]
     * @return void
     */
    public function setContent(InputStream $content = null) {
        $this->content = $content;
    }
}
