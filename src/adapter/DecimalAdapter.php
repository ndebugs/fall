<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\reflection\type\Type;
use ndebugs\fall\reflection\type\DecimalType;

/** @TypeAdapter(DecimalType::NAME) */
class DecimalAdapter implements BasicTypeAdaptable {
    
    /**
     * @param mixed $value
     * @param Type $type [optional]
     * @return double
     */
    public function cast($value, Type $type = null) {
        return (double) $value;
    }
    
    /**
     * @param double $value
     * @param Type $type [optional]
     * @return double
     */
    public function uncast($value, Type $type = null) {
        return (double) $value;
    }
    
    /**
     * @param string $value
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
