<?php

namespace ndebugs\fall\http;

use ndebugs\fall\adapter\ObjectTypeAdaptable;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;

class RequestHandler {
    
    /** @var ApplicationContext */
    private $context;
    
    /** @var RequestContext */
    private $requestContext;
    
    /** @var object[] */
    private $typeArguments = [];
    
    /** @var array */
    private $arguments = [];
    
    /**
     * @param ApplicationContext $context
     * @param RequestContext $requestContext
     */
    public function __construct(ApplicationContext $context, RequestContext $requestContext) {
        $this->context = $context;
        $this->requestContext = $requestContext;
        
        $this->init();
    }

    /** @return void */
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
    
    /**
     * @param string $key
     * @param string $type [optional]
     * @return mixed
     */
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
    
    /**
     * @param object $value
     * @return void
     */
    public function setTypeArgument($value) {
        $this->typeArguments[get_class($value)] = $value;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setArgument($key, $value) {
        $this->arguments[$key] = $value;
    }
    
    /** @return mixed */
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
                $adapter = $this->context->getTypeAdapter(ObjectTypeAdaptable::class, $type);
                $arguments[] = $adapter ? $adapter->wrap($argument) : $argument;
            } else {
                $arguments[] = $argument;
            }
        }
        
        $class = $route->getGroup()->getMetadata()->getName();
        $controller = $this->context->getComponent($class);
        return $method->invokeArgs($controller, $arguments);
    }
}
