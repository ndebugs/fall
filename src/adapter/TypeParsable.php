<?php

namespace ndebugs\fall\adapter;

interface TypeParsable {
    
    /**
     * @param string $value
     * @param string $type [optional]
     * @return mixed
     */
    public function parse($value, $type = null);
    
    /**
     * @param mixed $value
     * @return string
     */
    public function toString($value);
}
