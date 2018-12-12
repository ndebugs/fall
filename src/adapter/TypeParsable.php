<?php

namespace ndebugs\fall\adapter;

interface TypeParsable {
    
    /**
     * @param string $value
     * @return mixed
     */
    public function parse($value);
    
    /**
     * @param mixed $value
     * @return string
     */
    public function toString($value);
}
