<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\DataTypeAdapter;

/**
 * @DataTypeAdapter("boolean")
 */
class BooleanAdapter implements TypeAdapter {
    
    const TRUE_VALUE = 'true';
    const FALSE_VALUE = 'false';
    
    public function unmarshall($value) {
        return $value === BooleanAdapter::TRUE_VALUE;
    }
    
    public function marshall($value) {
        return $value ? BooleanAdapter::TRUE_VALUE : BooleanAdapter::FALSE_VALUE;
    }
}