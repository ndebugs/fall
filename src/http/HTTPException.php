<?php

namespace ndebugs\fall\http;

use Exception;
use Throwable;

class HTTPException extends Exception {
    
    /**
     * @param integer $code
     * @param string $message [optional]
     * @param Throwable $previous [optional]
     */
    public function __construct($code, $message = "", Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
    /** @return string */
    public function getDescription() {
        return HTTPStatus::description($this->getCode());
    }
}
