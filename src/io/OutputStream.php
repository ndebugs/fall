<?php

namespace ndebugs\fall\io;

abstract class OutputStream {
    
    const DEFAULT_WRITE_BUFFER = 8192;
    
    /**
     * @param string $data
     * @param integer $length [optional]
     * @return integer
     */
    public abstract function write($data, $length = -1);

    /** @return boolean */
    public abstract function flush();
    
    /** @return boolean */
    public abstract function close();
}
