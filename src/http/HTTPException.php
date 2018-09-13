<?php

namespace ndebugs\fall\http;

use Exception;
use Throwable;

class HTTPException extends Exception {
    
    public function __construct($code, $message = "", Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
    public function getDescription() {
        return HTTPStatus::description($this->getCode());
    }
}
