<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\annotation\TypeFilter;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\web\Template;

/** @TypeFilter("string") */
class StringResponseFilter implements ResponseFilterable {
    
    /**
     * @param HTTPResponse $response
     * @param mixed $value
     * @return Template
     */
    public function filter(HTTPResponse $response, $value) {
        return new Template($value);
    }
}
