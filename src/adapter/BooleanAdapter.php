<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/** @TypeAdapter("boolean") */
class BooleanAdapter extends BasicTypeAdapter {
    
    const TRUE_VALUE = 'true';
    const FALSE_VALUE = 'false';
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return boolean
     */
    public function cast($value, $type = null) {
        return (boolean) $value;
    }
    
    /**
     * @param boolean $value
     * @param string $type [optional]
     * @return boolean
     */
    public function uncast($value, $type = null) {
        return (boolean) $value;
    }
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return boolean
     */
    public function parse($value, $type = null) {
        return $value === BooleanAdapter::TRUE_VALUE;
    }
    
    /**
     * @param boolean $value
     * @return string
     */
    public function toString($value) {
        return $value ? BooleanAdapter::TRUE_VALUE : BooleanAdapter::FALSE_VALUE;
    }
}
