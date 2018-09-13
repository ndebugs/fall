<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\DocumentTypeAdapter;

/**
 * @DocumentTypeAdapter({
 *  "application/json",
 *  "application/javascript"
 * })
 */
class JSONAdapter implements TypeAdaptable {
    
    public function unmarshall($value) {
        return json_decode($value, true);
    }
    
    public function marshall($value) {
        return json_encode($value);
    }
}
