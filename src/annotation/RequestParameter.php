<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

interface RequestParameter {
    
    public function getAlias();
    
    public function evaluate(ApplicationContext $context, RequestContext $requestContext);
}