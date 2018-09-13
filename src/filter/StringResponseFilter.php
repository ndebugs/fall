<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\annotation\ResponseFilter;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\web\Template;

/** @ResponseFilter("string") */
class StringResponseFilter implements ResponseFilterable {
    
    public function filter(HTTPResponse $response, $value) {
        return new Template($value);
    }
}
