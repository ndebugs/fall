<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/** @TypeAdapter("integer") */
class IntegerAdapter implements DataTypeAdaptable {
    
    /**
     * @param mixed $value
     * @return integer
     */
    public function parse($value) {
        return intval($value);
    }
    
    /**
     * @param integer $value
     * @return string
     */
    public function toString($value) {
        return (string) $value;
    }
}
