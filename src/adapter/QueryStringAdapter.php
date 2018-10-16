<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\net\QueryString;

/** @TypeAdapter("application/x-www-form-urlencoded") */
class QueryStringAdapter extends DocumentTypeAdapter {
    
    /**
     * @param string $value
     * @param string $type [optional]
     * @return string[]
     */
    public function parse($value, $type = null) {
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
