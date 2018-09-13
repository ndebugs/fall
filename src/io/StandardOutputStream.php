<?php

namespace ndebugs\fall\io;

class StandardOutputStream extends OutputStream {
    
    private $stream;
    
    public function __construct($buffer = OutputStream::DEFAULT_WRITE_BUFFER) {
        $this->stream = fopen('php://output', 'w');
        
        stream_set_write_buffer($this->stream, $buffer);
    }

    public function write($data, $length = null) {
        if ($length !== null) {
            return fwrite($this->stream, $data, $length);
        } else {
            return fwrite($this->stream, $data);
        }
    }

    public function flush() {
        return fflush($this->stream);
    }
    
    public function close() {
        return fclose($this->stream);
    }
    
    public static function writeAll($data, $buffer = OutputStream::DEFAULT_WRITE_BUFFER) {
        $out = new StandardOutputStream($buffer);
        $out->write($data);
        $out->flush();
        $out->close();
    }
}
