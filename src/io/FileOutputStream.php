<?php

namespace ndebugs\fall\io;

class FileOutputStream {
    
    const DEFAULT_WRITE_BUFFER = 8192;
    
    private $stream;
    
    public function __construct($path, $append = false, $buffer = FileOutputStream::DEFAULT_WRITE_BUFFER) {
        $this->stream = fopen($path, $append ? 'a' : 'w');
        
        stream_set_write_buffer($this->stream, $buffer);
    }

    public function write($data, $length = null) {
        if ($length !== null) {
            return fwrite($this->stream, $data, $length);
        } else {
            return fwrite($this->stream, $data);
        }
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

    public function flush() {
        return fflush($this->stream);
    }
    
    public function close() {
        return fclose($this->stream);
    }
    
    public static function appendAll($path, $data, $buffer = FileOutputStream::DEFAULT_WRITE_BUFFER) {
        $out = new FileOutputStream($path, true, $buffer);
        $out->write($data);
        $out->close();
    }
    
    public static function writeAll($path, $data, $buffer = FileOutputStream::DEFAULT_WRITE_BUFFER) {
        $out = new FileOutputStream($path, false, $buffer);
        $out->write($data);
        $out->flush();
        $out->close();
    }
}
