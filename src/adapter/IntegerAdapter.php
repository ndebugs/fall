<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\reflection\type\Type;
use ndebugs\fall\reflection\type\IntegerType;

/** @TypeAdapter(IntegerType::NAME) */
class IntegerAdapter implements BasicTypeAdaptable {
    
    /**
     * @param mixed $value
     * @param Type $type [optional]
     * @return integer
     */
    public function cast($value, Type $type = null) {
        return (integer) $value;
    }
    
    /**
     * @param integer $value
     * @param Type $type [optional]
     * @return integer
     */
    public function uncast($value, Type $type = null) {
        return (integer) $value;
    }
    
    /**
     * @param string $value
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
