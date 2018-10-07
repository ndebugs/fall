<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class RequestMap {

    /** @var string */
    public $path = '';
    
    /** @var string */
    public $method = 'GET';
    
    /** @var string[] */
    public $headers;
}
