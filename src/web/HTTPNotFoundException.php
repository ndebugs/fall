<?php

namespace ndebugs\fall\web;

use Throwable;
use ndebugs\fall\http\HTTPException;
use ndebugs\fall\http\HTTPStatus;

class HTTPNotFoundException extends HTTPException {
    
    public function __construct($message = "", Throwable $previous = null) {
        parent::__construct(HTTPStatus::CODE_NOT_FOUND, $message, $previous);
    }
}
