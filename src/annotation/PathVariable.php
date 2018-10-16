<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\adapter\DataTypeAdapter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class PathVariable extends RequestAttribute {
    
    /** @var string */
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
            $adapter = $context->getTypeAdapter(DataTypeAdapter::class, $this->type);
            return $adapter ? $adapter->parse($value, $this->type) : null;
        } else {
            return $value;
        }
    }
}
