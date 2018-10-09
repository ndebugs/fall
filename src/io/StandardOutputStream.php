<?php

namespace ndebugs\fall\io;

class StandardOutputStream extends OutputStream {
    
    /** @var resource */
    private $stream;
    
    /**
     * @param integer $buffer [optional]
     */
    public function __construct($buffer = OutputStream::DEFAULT_WRITE_BUFFER) {
        $this->stream = fopen('php://output', 'w');
        
        stream_set_write_buffer($this->stream, $buffer);
    }

    /**
     * @param string $data
     * @param integer $length [optional]
     * @return integer
     */
    public function write($data, $length = -1) {
        if ($length != -1) {
            $result = fwrite($this->stream, $data, $length);
        } else {
            $result = fwrite($this->stream, $data);
        }
        return $result !== false ? $result : -1;
    }

    /** @return boolean */
    public function flush() {
        return fflush($this->stream);
    }
    
    /** @return boolean */
    public function close() {
        return fclose($this->stream);
    }
    
    /**
     * @param string $data
     * @param integer $buffer [optional]
     * @return void
     */
    public static function writeAll($data, $buffer = OutputStream::DEFAULT_WRITE_BUFFER) {
        $out = new StandardOutputStream($buffer);
        $out->write($data);
        $out->flush();
        $out->close();
    }
}
