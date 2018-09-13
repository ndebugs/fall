<?php

namespace ndebugs\fall\http;

use ndebugs\fall\io\OutputStream;

class HTTPResponse extends HTTPMessage {
    
    private $content;
    
    public function setStatusCode($statusCode) {
        http_response_code($statusCode);
    }

    public function setHeader($key, $value) {
        header($key . ': ' . $value);
    }
    
    public function setContentLength($value) {
        $this->setHeader(self::HEADER_CONTENT_LENGTH, $value);
    }
    
    public function setContentType($value) {
        $this->setHeader(self::HEADER_CONTENT_TYPE, $value);
    }
    
    public function getContent() {
        return $this->content;
    }

    public function setContent(OutputStream $content = null) {
        $this->content = $content;
    }
}
