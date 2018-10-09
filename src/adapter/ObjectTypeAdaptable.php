<?php

namespace ndebugs\fall\adapter;

interface ObjectTypeAdaptable {
    
    /**
     * @param mixed $value
     * @return object
     */
    public function wrap($value);
    
    /**
     * @param object $value
     * @return mixed
     */
    public function unwrap($value);
}
