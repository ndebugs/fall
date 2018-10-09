<?php

namespace ndebugs\fall\io;

class FileInputStream extends InputStream {
    
    /** @var resource */
    private $stream;
    
    /** @param string $path */
    public function __construct($path) {
        $this->stream = fopen($path, 'r');
    }

    /** @return boolean */
    public function hasNext() {
        return !feof($this->stream);
    }

    /**
     * @param integer $length [optional]
     * @return string
     */
    public function read($length = 1) {
        return fread($this->stream, $length);
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
    public function close() {
        return fclose($this->stream);
    }
    
    /**
     * @param string $path
     * @param integer $buffer [optional]
     * @return string
     */
    public static function readAll($path, $buffer = InputStream::DEFAULT_READ_BUFFER) {
        $in = new FileInputStream($path);
        $data = '';
        while ($in->hasNext()) {
            $data .= $in->read($buffer);
        }
        $in->close();
        
        return $data;
    }
}
