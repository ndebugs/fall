<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class QueryParameter implements RequestParameter {
    
    /** @var string */
    public $name;
    
    /** @var string */
    public $alias;
    
    /**
     * @var string
     */
    public $type;
    
    public function getAlias() {
        return $this->alias !== null ? $this->alias : $this->name;
    }

    public function evaluate(ApplicationContext $context, RequestContext $requestContext) {
        $request = $requestContext->getValue();
        $query = $request->getURL()->getQuery();
        $value = $query->get($this->name);
        
        if ($this->type) {
            $adapter = $context->getDataTypeAdapter($this->type);
            return $adapter ? $adapter->unmarshall($value) : null;
        } else {
            return $value;
        }
    }
}