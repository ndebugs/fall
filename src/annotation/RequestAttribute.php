<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

abstract class RequestAttribute {
    
    public abstract function getAlias();
    
    public abstract function evaluate(ApplicationContext $context, RequestContext $requestContext);
}
