<?php

namespace ndebugs\fall\io;

class FileOutputStream extends OutputStream {
    
    /** @var resource */
    private $stream;
    
    /**
     * @param string $path
     * @param boolean $append [optional]
     * @param integer $buffer [optional]
     */
    public function __construct($path, $append = false, $buffer = OutputStream::DEFAULT_WRITE_BUFFER) {
        $this->stream = fopen($path, $append ? 'a' : 'w');
        
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

    /**
     * @param integer $offset [optional]
     * @return boolean
     */
    public function reset($offset = 0) {
        return fseek($this->stream, $offset) !== -1;
    }

    /**
     * @param integer $offset
     * @return boolean
     */
    public function skip($offset) {
        return fseek($this->stream, $offset, SEEK_CUR) !== -1;
    }

    /**
     * @param integer $offset [optional]
     * @return boolean
     */
    public function skipLast($offset = 0) {
        return fseek($this->stream, $offset, SEEK_END) !== -1;
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
     * @param string $path
     * @param string $data
     * @param integer $buffer [optional]
     * @return void
     */
    public static function appendAll($path, $data, $buffer = OutputStream::DEFAULT_WRITE_BUFFER) {
        $out = new FileOutputStream($path, true, $buffer);
        $out->write($data);
        $out->close();
    }
    
    /**
     * @param string $path
     * @param string $data
     * @param integer $buffer [optional]
     * @return void
     */
    public static function writeAll($path, $data, $buffer = OutputStream::DEFAULT_WRITE_BUFFER) {
        $out = new FileOutputStream($path, false, $buffer);
        $out->write($data);
        $out->flush();
        $out->close();
    }
}
