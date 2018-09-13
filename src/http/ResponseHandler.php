<?php

namespace ndebugs\fall\http;

use ndebugs\fall\annotation\ResponseAttribute;
use ndebugs\fall\annotation\ResponseFilter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPResponse;

class ResponseHandler {
    
    private $context;
    private $response;
    
    public function __construct(ApplicationContext $context, HTTPResponse $response) {
        $this->context = $context;
        $this->response = $response;
    }
    
    private function processFilter($value) {
        do {
            $adapter = $this->context->getTypeFilter(ResponseFilter::class, $value);
            $value = $adapter ? $adapter->filter($this->response, $value) : null;
        } while ($value);
    }
    
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
