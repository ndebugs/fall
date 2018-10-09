<?php

namespace ndebugs\fall\http;

use ndebugs\fall\io\OutputStream;

class HTTPResponse extends HTTPMessage {
    
    /** @var OutputStream */
    private $content;
    
    /**
     * @param integer $statusCode
     * @return void
     */
    public function setStatusCode($statusCode) {
        http_response_code($statusCode);
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setHeader($key, $value) {
        header($key . ': ' . $value);
    }
    
    /**
     * @param integer $value
     * @return void
     */
    public function setContentLength($value) {
        $this->setHeader(self::HEADER_CONTENT_LENGTH, $value);
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setContentType($value) {
        $this->setHeader(self::HEADER_CONTENT_TYPE, $value);
    }
    
    /** @return OutputStream */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param OutputStream $content [optional]
     * @return void
     */
    public function setContent(OutputStream $content = null) {
        $this->content = $content;
    }
}
