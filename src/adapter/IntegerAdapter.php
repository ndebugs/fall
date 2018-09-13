<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\DataTypeAdapter;

/** @DataTypeAdapter("integer") */
class IntegerAdapter implements TypeAdaptable {
    
    public function unmarshall($value) {
        return intval($value);
    }
    
    public function marshall($value) {
        return (string) $value;
    }
}
