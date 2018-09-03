<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class RequestBody implements RequestParameter {
    
    /**
     * @var string
     * @Required
     */
    public $alias;
    
    /**
     * @var string
     */
    public $adapter;
    
    public function getAlias() {
        return $this->alias;
    }

    public function evaluate(ApplicationContext $context, RequestContext $requestContext) {
        $content = $requestContext->getContent($context);
        
        $adapter = $this->adapter ? $context->getComponent($this->adapter) : null;
        return $adapter ? $adapter->unmarshall($content) : $content;
    }
}