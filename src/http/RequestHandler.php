<?php

namespace ndebugs\fall\http;

use ndebugs\fall\annotation\DataTypeAdapter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

class RequestHandler {
    
    private $context;
    private $requestContext;
    private $typeArguments = [];
    private $arguments = [];
    
    public function __construct(ApplicationContext $context, RequestContext $requestContext) {
        $this->context = $context;
        $this->requestContext = $requestContext;
        
        $this->init();
    }

    private function init() {
        $route = $this->requestContext->getRoute();
        $attributes = $route->getRequestAttributes();
        if ($attributes) {
            foreach ($attributes as $attribute) {
                $value = $attribute->evaluate($this->context, $this->requestContext);
                $this->setArgument($attribute->getAlias(), $value);
            }
        }
    }
    
    public function getArgument($key, $type = null) {
        $value = null;
        if ($type && isset($this->typeArguments[$type])) {
            $value = $this->typeArguments[$type];
        }
        
        if (!$value !== null && isset($this->arguments[$key])) {
            return $this->arguments[$key];
        } else {
            return $value;
        }
    }
    
    public function setTypeArgument($value) {
        $this->typeArguments[get_class($value)] = $value;
    }
    
    public function setArgument($key, $value) {
        $this->arguments[$key] = $value;
    }
    
    public function process() {
        $route = $this->requestContext->getRoute();
        $method = $route->getAction();
        $parameters = $method->getParameters();
        $arguments = [];
        foreach ($parameters as $parameter) {
            $key = $parameter->getName();
            $type = $parameter->getClass() ? $parameter->getClass()->getName() : null;
            
            $argument = $this->getArgument($key, $type);
            if ($type && !$argument instanceof $type) {
                $adapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $type);
                $arguments[] = $adapter ? $adapter->unmarshall($argument) : $argument;
            } else {
                $arguments[] = $argument;
            }
        }
        
        $class = $route->getGroup()->getController();
        $controller = $this->context->getComponent($class);
        return $method->invokeArgs($controller, $arguments);
    }
}
