<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\annotation\DataTypeAdapter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

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
    
    public function getAlias() {
        return $this->alias;
    }

    public function evaluate(ApplicationContext $context, RequestContext $requestContext) {
        $value = $requestContext->getContent($context);
        
        if ($this->type) {
            $adapter = $context->getTypeAdapter(DataTypeAdapter::class, $this->type);
            return $adapter ? $adapter->unmarshall($value) : null;
        } else {
            return $value;
        }
    }
}
