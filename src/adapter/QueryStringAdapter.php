<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\DocumentTypeAdapter;
use ndebugs\fall\net\QueryString;

/** @DocumentTypeAdapter("application/x-www-form-urlencoded") */
class QueryStringAdapter implements TypeAdapter {
    
    public function unmarshall($value) {
        $query = QueryString::parse($value);
        return $query->getValues();
    }
    
    public function marshall($value) {
        $query = new QueryString($value);
        return (string) $query;
    }
}