<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\adapter\ObjectTypeAdaptable;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;
use ndebugs\fall\reflection\TypeResolver;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class RequestBody extends RequestAttribute {
    
    /**
     * @var string
     * @Required
     */
    public $alias;
    
    /** @var string */
    public $type;
    
    /** @return string */
    public function getAlias() {
        return $this->alias;
    }

    /**
     * @param ApplicationContext $context
     * @param RequestContext $requestContext
     * @return mixed
     */
    public function evaluate(ApplicationContext $context, RequestContext $requestContext) {
        $value = $requestContext->getContent($context);
        
        if ($this->type) {
            $type = TypeResolver::fromString($this->type);
            $adapter = $context->getTypeAdapter(ObjectTypeAdaptable::class, $type);
            return $adapter ? $adapter->cast($value, $type) : null;
        } else {
            return $value;
        }
    }
}
