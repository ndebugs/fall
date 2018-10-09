<?php

namespace ndebugs\fall\io;

abstract class InputStream {
    
    const DEFAULT_READ_BUFFER = 8192;
    
    /** @return boolean */
    public abstract function hasNext();

    /**
     * @param integer $length [optional]
     * @return string
     */
    public abstract function read($length = 1);

    /**
     * @param integer $offset [optional]
     * @return boolean
     */
    public abstract function reset($offset = 0);

    /**
     * @param integer $offset
     * @return boolean
     */
    public abstract function skip($offset);

    /** @return boolean */
    public abstract function close();
}
