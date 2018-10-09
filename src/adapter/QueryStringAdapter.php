<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\net\QueryString;

/** @TypeAdapter("application/x-www-form-urlencoded") */
class QueryStringAdapter implements DocumentTypeAdaptable {
    
    /**
     * @param string $value
     * @return string[]
     */
    public function unmarshall($value) {
        $query = QueryString::parse($value);
        return $query->getValues();
    }
    
    /**
     * @param string[] $value
     * @return string
     */
    public function marshall($value) {
        $query = new QueryString($value);
        return (string) $query;
    }
}
