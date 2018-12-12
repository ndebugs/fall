<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\StaticTypeAdapter;

/**
 * @StaticTypeAdapter({
 *  "application/json",
 *  "application/javascript"
 * })
 */
class JSONAdapter implements DocumentTypeAdaptable {
    
    /**
     * @param string $value
     * @return mixed
     */
    public function parse($value) {
        return json_decode($value, true);
    }
    
    /**
     * @param mixed $value
     * @return string
     */
    public function toString($value) {
        return json_encode($value);
    }
}
