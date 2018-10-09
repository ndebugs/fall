<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPResponse;

abstract class ResponseAttribute {
    
    /**
     * @param ApplicationContext $context
     * @param HTTPResponse $response
     * @param mixed $value
     * @return mixed
     */
    public abstract function evaluate(ApplicationContext $context, HTTPResponse $response, $value);
}
