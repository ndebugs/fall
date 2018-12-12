<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\reflection\type\Type;
use ndebugs\fall\reflection\type\BooleanType;

/** @TypeAdapter(BooleanType::NAME) */
class BooleanAdapter implements BasicTypeAdaptable {
    
    const TRUE_VALUE = 'true';
    const FALSE_VALUE = 'false';
    
    /**
     * @param mixed $value
     * @param Type $type [optional]
     * @return boolean
     */
    public function cast($value, Type $type = null) {
        return (boolean) $value;
    }
    
    /**
     * @param boolean $value
     * @param Type $type [optional]
     * @return boolean
     */
    public function uncast($value, Type $type = null) {
        return (boolean) $value;
    }
    
    /**
     * @param string $value
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
