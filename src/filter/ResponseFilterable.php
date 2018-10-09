<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\http\HTTPResponse;

interface ResponseFilterable {
    
    /**
     * @param HTTPResponse $response
     * @param mixed $value
     * @return mixed
     */
    public function filter(HTTPResponse $response, $value);
}
