<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/** @TypeAdapter("double") */
class DoubleAdapter implements DataTypeAdaptable {
    
    /**
     * @param mixed $value
     * @return double
     */
    public function parse($value) {
        return floatval($value);
    }
    
    /**
     * @param double $value
     * @return string
     */
    public function toString($value) {
        return (string) $value;
    }
}
