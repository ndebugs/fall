<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\StaticTypeAdapter;
use ndebugs\fall\net\QueryString;

/** @StaticTypeAdapter("application/x-www-form-urlencoded") */
class QueryStringAdapter implements DocumentTypeAdaptable {
    
    /**
     * @param string $value
     * @return string[]
     */
    public function parse($value) {
        $query = QueryString::parse($value);
        return $query->getValues();
    }
    
    /**
     * @param string[] $value
     * @return string
     */
    public function toString($value) {
        $query = new QueryString($value);
        return (string) $query;
    }
}
