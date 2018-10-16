<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/** @TypeAdapter("double") */
class DoubleAdapter extends BasicTypeAdapter {
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return double
     */
    public function cast($value, $type = null) {
        return (double) $value;
    }
    
    /**
     * @param double $value
     * @param string $type [optional]
     * @return double
     */
    public function uncast($value, $type = null) {
        return (double) $value;
    }
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return double
     */
    public function parse($value, $type = null) {
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
