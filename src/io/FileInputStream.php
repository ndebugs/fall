<?php

namespace ndebugs\fall\io;

class FileInputStream {
    
    const DEFAULT_READ_BUFFER = 8192;
    
    private $stream;
    
    public function __construct($path) {
        $this->stream = fopen($path, 'r');
    }

    public function hasNext() {
        return !feof($this->stream);
    }

    public function read($length) {
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
    
    public static function readAll($path, $buffer = FileInputStream::DEFAULT_READ_BUFFER) {
        $in = new FileInputStream($path);
        $data = '';
        while ($in->hasNext()) {
            $data .= $in->read($buffer);
        }
        $in->close();
        
        return $data;
    }
}
