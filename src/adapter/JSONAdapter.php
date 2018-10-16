<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;

/**
 * @TypeAdapter({
 *  "application/json",
 *  "application/javascript"
 * })
 */
class JSONAdapter extends DocumentTypeAdapter {
    
    /**
     * @param string $value
     * @param string $type [optional]
     * @return mixed
     */
    public function parse($value, $type = null) {
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
