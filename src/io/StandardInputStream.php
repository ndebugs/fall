<?php

namespace ndebugs\fall\io;

class StandardInputStream extends InputStream {
    
    private $stream;
    
    public function __construct() {
        $this->stream = fopen('php://input', 'r');
    }

    public function hasNext() {
        return !feof($this->stream);
    }

    public function read($length = 1) {
        return fread($this->stream, $length);
    }

    public function reset($offset = 0) {
        return fseek($this->stream, $offset);
    }

    public function skip($offset) {
        return fseek($this->stream, $offset, SEEK_CUR);
    }

    public function skipLast($offset = 0) {
        return fseek($this->stream, $offset, SEEK_END);
    }

    public function close() {
        return fclose($this->stream);
    }
    
    public static function readAll($buffer = InputStream::DEFAULT_READ_BUFFER) {
        $in = new StandardInputStream();
        $data = '';
        while ($in->hasNext()) {
            $data .= $in->read($buffer);
        }
        $in->close();
        
        return $data;
    }
}
