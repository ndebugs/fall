<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/**
 * @TypeAdapter({
 *  "application/json",
 *  "application/javascript"
 * })
 */
class JSONAdapter implements DocumentTypeAdaptable {
    
    /**
     * @param string $value
     * @return mixed
     */
    public function unmarshall($value) {
        return json_decode($value, true);
    }
    
    /**
     * @param mixed $value
     * @return string
     */
    public function marshall($value) {
        return json_encode($value);
    }
}
