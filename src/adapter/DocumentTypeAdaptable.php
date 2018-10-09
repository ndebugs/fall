<?php

namespace ndebugs\fall\adapter;

interface DocumentTypeAdaptable {
    
    /**
     * @param string $value
     * @return mixed
     */
    public function unmarshall($value);
    
    /**
     * @param mixed $value
     * @return string
     */
    public function marshall($value);
}
