<?php

namespace ndebugs\fall\routing;

use ReflectionMethod;
use ndebugs\fall\annotation\RequestAttribute;
use ndebugs\fall\annotation\RequestMap;
use ndebugs\fall\annotation\ResponseAttribute;
use ndebugs\fall\annotation\Roles;
use ndebugs\fall\net\Path;
use ndebugs\fall\routing\Route;
use ndebugs\fall\routing\RouteGroup;

class RouteBuilder {
    
    private $group;
    private $action;
    private $path;
    private $method;
    private $headers;
    private $requestAttributes;
    private $responseAttribute;
    private $roles;
    
    public function setGroup(RouteGroup $group) {
        $this->group = $group;
        
        return $this;
    }

    public function setAction(ReflectionMethod $action) {
        $this->action = $action;
        
        return $this;
    }
    
    public function setRequestMap(RequestMap $requestMap) {
        $this->path = Path::parseURL($requestMap->path);
        $this->method = $requestMap->method;
        $this->headers = $requestMap->headers;
        
        return $this;
    }
    
    public function addRequestAttribute(RequestAttribute $attribute) {
        if (!$this->requestAttributes) {
            $this->requestAttributes = [$attribute];
        } else {
            $this->requestAttributes[] = $attribute;
        }
        
        return $this;
    }
    
    public function setResponseAttribute(ResponseAttribute $attribute) {
        $this->responseAttribute = $attribute;
        
        return $this;
    }
    
    public function setRoles(Roles $roles = null) {
        $this->roles = $roles ? $roles->values : null;
        
        return $this;
    }
    
    public function build() {
        $route = new Route();
        $route->setGroup($this->group);
        $route->setAction($this->action);
        $route->setPath($this->path);
        $route->setMethod($this->method);
        $route->setHeaders($this->headers);
        $route->setRequestAttributes($this->requestAttributes);
        $route->setResponseAttribute($this->responseAttribute);
        $route->setRoles($this->roles);
        
        return $route;
    }
}
