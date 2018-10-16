<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/** @TypeAdapter("string") */
class StringAdapter extends BasicTypeAdapter {
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return string
     */
    public function cast($value, $type = null) {
        return $value !== null ? (string) $value : null;
    }
    
    /**
     * @param string $value
     * @param string $type [optional]
     * @return string
     */
    public function uncast($value, $type = null) {
        return $value !== null ? (string) $value : null;
    }
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return string
     */
    public function parse($value, $type = null) {
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
