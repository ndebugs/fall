<?php

namespace ndebugs\fall\web;

use Throwable;
use ndebugs\fall\http\HTTPException;
use ndebugs\fall\http\HTTPStatus;

class HTTPInternalServerErrorException extends HTTPException {
    
    /**
     * @param string $message [optional]
     * @param Throwable $previous [optional]
     */
    public function __construct($message = "", Throwable $previous = null) {
        parent::__construct(HTTPStatus::CODE_INTERNAL_SERVER_ERROR, $message, $previous);
    }
}
