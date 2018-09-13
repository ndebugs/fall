<?php

namespace ndebugs\fall\io;

abstract class OutputStream {
    
    const DEFAULT_WRITE_BUFFER = 8192;
    
    public abstract function write($data, $length = null);

    public abstract function flush();
    
    public abstract function close();
}
