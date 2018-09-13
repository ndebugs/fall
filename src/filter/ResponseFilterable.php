<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\http\HTTPResponse;

interface ResponseFilterable {
    
    public function filter(HTTPResponse $response, $value);
}
