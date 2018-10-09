<?php

namespace ndebugs\fall\adapter;

interface DataTypeAdaptable {
    
    /**
     * @param mixed $value
     * @return mixed
     */
    public function parse($value);
    
    /**
     * @param mixed $value
     * @return string
     */
    public function toString($value);
}
