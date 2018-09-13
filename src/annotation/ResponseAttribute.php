<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPResponse;

abstract class ResponseAttribute {
    
    public abstract function evaluate(ApplicationContext $context, HTTPResponse $response, $value);
}
