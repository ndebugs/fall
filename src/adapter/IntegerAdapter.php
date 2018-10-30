<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/** @TypeAdapter({"int", "integer"}) */
class IntegerAdapter extends BasicTypeAdapter {
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return integer
     */
    public function cast($value, $type = null) {
        return (integer) $value;
    }
    
    /**
     * @param integer $value
     * @param string $type [optional]
     * @return integer
     */
    public function uncast($value, $type = null) {
        return (integer) $value;
    }
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return integer
     */
    public function parse($value, $type = null) {
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
