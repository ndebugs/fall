<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\DataTypeAdapter;

/**
 * @DataTypeAdapter("int")
 */
class IntegerAdapter implements TypeAdapter {
    
    public function unmarshall($value) {
        return intval($value);
    }
    
    public function marshall($value) {
        return (string) $value;
    }
}