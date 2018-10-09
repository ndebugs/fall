<?php

namespace ndebugs\fall\http;

use ndebugs\fall\annotation\ResponseAttribute;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\filter\ResponseFilterable;
use ndebugs\fall\http\HTTPResponse;

class ResponseHandler {
    
    /** @var ApplicationContext */
    private $context;
    
    /** @var HTTPResponse */
    private $response;
    
    /**
     * @param ApplicationContext $context
     * @param HTTPResponse $response
     */
    public function __construct(ApplicationContext $context, HTTPResponse $response) {
        $this->context = $context;
        $this->response = $response;
    }
    
    /**
     * @param mixed $value
     * @return void
     */
    private function processFilter($value) {
        do {
            $adapter = $this->context->getTypeFilter(ResponseFilterable::class, $value);
            $value = $adapter ? $adapter->filter($this->response, $value) : null;
        } while ($value);
    }
    
    /**
     * @param mixed $value
     * @param ResponseAttribute $attribute [optional]
     * @return void
     */
    public function process($value, ResponseAttribute $attribute = null) {
        if ($attribute) {
            $value = $attribute->evaluate($this->context, $this->response, $value);
        }
        
        $this->processFilter($value);
        
        $out = $this->response->getContent();
        $out->flush();
        $out->close();
    }
}
