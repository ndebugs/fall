<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

abstract class RequestAttribute {
    
    /** @return string */
    public abstract function getAlias();
    
    /**
     * @param ApplicationContext $context
     * @param RequestContext $requestContext
     * @return mixed
     */
    public abstract function evaluate(ApplicationContext $context, RequestContext $requestContext);
}
