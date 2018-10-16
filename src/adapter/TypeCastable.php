<?php

namespace ndebugs\fall\adapter;

interface TypeCastable {
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return mixed
     */
    public function cast($value, $type = null);
    
    /**
     * @param mixed $value
     * @return mixed
     */
    public function uncast($value);
}
