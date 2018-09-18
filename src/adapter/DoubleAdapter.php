<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\DataTypeAdapter;

/** @DataTypeAdapter("double") */
class DoubleAdapter implements TypeAdaptable {
    
    public function unmarshall($value) {
        return floatval($value);
    }
    
    public function marshall($value) {
        return (string) $value;
    }
}
