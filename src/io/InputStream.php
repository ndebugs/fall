<?php

namespace ndebugs\fall\io;

abstract class InputStream {
    
    const DEFAULT_READ_BUFFER = 8192;
    
    public abstract function hasNext();

    public abstract function read($length = 1);

    public abstract function reset($offset = 0);

    public abstract function skip($offset);

    public abstract function close();
}
