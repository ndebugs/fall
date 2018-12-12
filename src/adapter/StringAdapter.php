<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\reflection\type\Type;
use ndebugs\fall\reflection\type\StringType;

/** @TypeAdapter(StringType::NAME) */
class StringAdapter implements BasicTypeAdaptable {
    
    /**
     * @param mixed $value
     * @param Type $type [optional]
     * @return string
     */
    public function cast($value, Type $type = null) {
        return $value !== null ? (string) $value : null;
    }
    
    /**
     * @param string $value
     * @param Type $type [optional]
     * @return string
     */
    public function uncast($value, Type $type = null) {
        return $value !== null ? (string) $value : null;
    }
    
    /**
     * @param string $value
     * @return string
     */
    public function parse($value) {
        return $value !== null ? (string) $value : null;
    }
    
    /**
     * @param string $value
     * @return string
     */
    public function toString($value) {
        return $value !== null ? (string) $value : null;
    }
}
