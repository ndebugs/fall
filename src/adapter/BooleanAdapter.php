<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/** @TypeAdapter("boolean") */
class BooleanAdapter implements DataTypeAdaptable {
    
    const TRUE_VALUE = 'true';
    const FALSE_VALUE = 'false';
    
    /**
     * @param mixed $value
     * @return boolean
     */
    public function parse($value) {
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
