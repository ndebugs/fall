<?php

namespace ndebugs\fall\web;

use Throwable;
use ndebugs\fall\http\HTTPException;
use ndebugs\fall\http\HTTPStatus;
use ndebugs\fall\net\URL;

class HTTPNotFoundException extends HTTPException {
    
    /**
     * @param string $message [optional]
     * @param Throwable $previous [optional]
     */
    public function __construct($message = "", Throwable $previous = null) {
        parent::__construct(HTTPStatus::CODE_NOT_FOUND, $message, $previous);
    }
    
    /**
     * @param URL $url
     * @return HTTPNotFoundException
     */
    public static function forURL(URL $url) {
        $message = 'The requested URL ' . $url . ' was not found on this server.';
        return new HTTPNotFoundException($message);
    }
}
