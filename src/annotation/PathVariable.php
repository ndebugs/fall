<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\adapter\BasicTypeAdaptable;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;
use ndebugs\fall\reflection\TypeResolver;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class PathVariable extends RequestAttribute {
    
    /**
     * @var string
     * @Required
     */
    public $name;
    
    /** @var string */
    public $alias;
    
    /** @var string */
    public $type;
    
    /** @return string */
    public function getAlias() {
        return $this->alias !== null ? $this->alias : $this->name;
    }

    /**
     * @param ApplicationContext $context
     * @param RequestContext $requestContext
     * @return mixed
     */
    public function evaluate(ApplicationContext $context, RequestContext $requestContext) {
        $value = $requestContext->getPathVariable($this->name);
        
        if ($this->type) {
            $type = TypeResolver::fromString($this->type);
            $adapter = $context->getTypeAdapter(BasicTypeAdaptable::class, $type);
            return $adapter ? $adapter->parse($value) : null;
        } else {
            return $value;
        }
    }
}
