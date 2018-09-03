<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\DataTypeAdapter;

/**
 * @DataTypeAdapter("float")
 */
class FloatAdapter implements TypeAdapter {
    
    public function unmarshall($value) {
        return floatval($value);
    }
    
    public function marshall($value) {
        return (string) $value;
    }
}