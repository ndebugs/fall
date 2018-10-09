<?php

namespace ndebugs\fall\http;

class HTTPStatus {

    // Informational 1xx
    const CODE_CONTINUE = 100;
    const CODE_SWITCHING_PROTOCOLS = 101;
    
    // Successful 2xx
    const CODE_OK = 200;
    const CODE_CREATED = 201;
    const CODE_ACCEPTED = 202;
    const CODE_NON_AUTHORITATIVE_INFORMATION = 203;
    const CODE_NO_CONTENT = 204;
    const CODE_RESET_CONTENT = 205;
    const CODE_PARTIAL_CONTENT = 206;
    
    // Redirection 3xx
    const CODE_MULTIPLE_CHOICES = 300;
    const CODE_MOVED_PERMANENTLY = 301;
    const CODE_FOUND = 302;
    const CODE_SEE_OTHER = 303;
    const CODE_NOT_MODIFIED = 304;
    const CODE_USE_PROXY = 305;
    const CODE_TEMPORARY_REDIRECT = 307;
    const CODE_BAD_REQUEST = 400;
    const CODE_UNAUTHORIZED = 401;
    const CODE_PAYMENT_REQUIRED = 402;
    const CODE_FORBIDDEN = 403;
    const CODE_NOT_FOUND = 404;
    const CODE_METHOD_NOT_ALLOWED = 405;
    const CODE_NOT_ACCEPTABLE = 406;
    const CODE_PROXY_AUTHENTICATION_REQUIRED = 407;
    const CODE_REQUEST_TIME_OUT = 408;
    const CODE_CONFLICT = 409;
    const CODE_GONE = 410;
    const CODE_LENGTH_REQUIRED = 411;
    const CODE_PRECONDITION_FAILED = 412;
    const CODE_REQUEST_ENTITY_TOO_LARGE = 413;
    const CODE_REQUEST_URI_TOO_LARGE = 414;
    const CODE_UNSUPPORTED_MEDIA_TYPE = 415;
    const CODE_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const CODE_EXPECTATION_FAILED = 417;
    
    // Server Error 5xx
    const CODE_INTERNAL_SERVER_ERROR = 500;
    const CODE_NOT_IMPLEMENTED = 501;
    const CODE_BAD_GATEWAY = 502;
    const CODE_SERVICE_UNAVAILABLE = 503;
    const CODE_GATEWAY_TIME_OUT = 504;
    const CODE_HTTP_VERSION_NOT_SUPPORTED = 505;

    /**
     * @param integer $code
     * @return string
     */
    public static function description($code) {
        switch ($code) {
            case HTTPStatus::CODE_CONTINUE:
                return "Continue";
            case HTTPStatus::CODE_SWITCHING_PROTOCOLS:
                return "Switching Protocols";
            case HTTPStatus::CODE_OK:
                return "OK";
            case HTTPStatus::CODE_CREATED:
                return "Created";
            case HTTPStatus::CODE_ACCEPTED:
                return "Accepted";
            case HTTPStatus::CODE_NON_AUTHORITATIVE_INFORMATION:
                return "Non-Authoritative Information";
            case HTTPStatus::CODE_NO_CONTENT:
                return "No Content";
            case HTTPStatus::CODE_RESET_CONTENT:
                return "Reset Content";
            case HTTPStatus::CODE_PARTIAL_CONTENT:
                return "Partial Content";
            case HTTPStatus::CODE_MULTIPLE_CHOICES:
                return "Multiple Choices";
            case HTTPStatus::CODE_MOVED_PERMANENTLY:
                return "Moved Permanently";
            case HTTPStatus::CODE_FOUND:
                return "Found";
            case HTTPStatus::CODE_SEE_OTHER:
                return "See Other";
            case HTTPStatus::CODE_NOT_MODIFIED:
                return "Not Modified";
            case HTTPStatus::CODE_USE_PROXY:
                return "Use Proxy";
            case HTTPStatus::CODE_TEMPORARY_REDIRECT:
                return "Temporary Redirect";
            case HTTPStatus::CODE_BAD_REQUEST:
                return "Bad Request";
            case HTTPStatus::CODE_UNAUTHORIZED:
                return "Unauthorized";
            case HTTPStatus::CODE_PAYMENT_REQUIRED:
                return "Payment Required";
            case HTTPStatus::CODE_FORBIDDEN:
                return "Forbidden";
            case HTTPStatus::CODE_NOT_FOUND:
                return "Not Found";
            case HTTPStatus::CODE_METHOD_NOT_ALLOWED:
                return "Method Not Allowed";
            case HTTPStatus::CODE_NOT_ACCEPTABLE:
                return "Not Acceptable";
            case HTTPStatus::CODE_PROXY_AUTHENTICATION_REQUIRED:
                return "Proxy Authentication Required";
            case HTTPStatus::CODE_REQUEST_TIME_OUT:
                return "Request Time-out";
            case HTTPStatus::CODE_CONFLICT:
                return "Conflict";
            case HTTPStatus::CODE_GONE:
                return "Gone";
            case HTTPStatus::CODE_LENGTH_REQUIRED:
                return "Length Required";
            case HTTPStatus::CODE_PRECONDITION_FAILED:
                return "Precondition Failed";
            case HTTPStatus::CODE_REQUEST_ENTITY_TOO_LARGE:
                return "Request Entity Too Large";
            case HTTPStatus::CODE_REQUEST_URI_TOO_LARGE:
                return "Request-URI Too Large";
            case HTTPStatus::CODE_UNSUPPORTED_MEDIA_TYPE:
                return "Unsupported Media Type";
            case HTTPStatus::CODE_REQUESTED_RANGE_NOT_SATISFIABLE:
                return "Requested range not satisfiable";
            case HTTPStatus::CODE_EXPECTATION_FAILED:
                return "Expectation Failed";
            case HTTPStatus::CODE_INTERNAL_SERVER_ERROR:
                return "Internal Server Error";
            case HTTPStatus::CODE_NOT_IMPLEMENTED:
                return "Not Implemented";
            case HTTPStatus::CODE_BAD_GATEWAY:
                return "Bad Gateway";
            case HTTPStatus::CODE_SERVICE_UNAVAILABLE:
                return "Service Unavailable";
            case HTTPStatus::CODE_GATEWAY_TIME_OUT:
                return "Gateway Time-out";
            case HTTPStatus::CODE_HTTP_VERSION_NOT_SUPPORTED:
                return "HTTP Version not supported";
        }
        return null;
    }

}
