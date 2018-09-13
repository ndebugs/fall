<?php

namespace ndebugs\fall\http;

abstract class HTTPMessage {
    
    // General Headers
    const HEADER_CACHE_CONTROL = 'Cache-Control';
    const HEADER_CONNECTION = 'Connection';
    const HEADER_DATE = 'Date';
    const HEADER_PRAGMA = 'Pragma';
    const HEADER_TRAILER = 'Trailer';
    const HEADER_TRANSFER_ENCODING = 'Transfer-Encoding';
    const HEADER_UPGRADE = 'Upgrade';
    const HEADER_VIA = 'Via';
    const HEADER_WARNING = 'Warning';
    
    // Entity Headers
    const HEADER_ALLOW = 'Allow';
    const HEADER_CONTENT_ENCODING = 'Content-Encoding';
    const HEADER_CONTENT_LANGUAGE = 'Content-Language';
    const HEADER_CONTENT_LENGTH = 'Content-Length';
    const HEADER_CONTENT_LOCATION = 'Content-Location';
    const HEADER_CONTENT_MD5 = 'Content-MD5';
    const HEADER_CONTENT_RANGE = 'Content-Range';
    const HEADER_CONTENT_TYPE = 'Content-Type';
    const HEADER_EXPIRES = 'Expires';
    const HEADER_LAST_MODIFIED = 'Last-Modified';
    
    public abstract function setHeader($key, $value);
}
