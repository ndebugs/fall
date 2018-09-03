<?php

namespace ndebugs\fall\routing;

use ReflectionMethod;
use ndebugs\fall\annotation\RequestMap;
use ndebugs\fall\annotation\RequestParameter;
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
    private $parameters;
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
    
    public function addParameter(RequestParameter $parameter) {
        if (!$this->parameters) {
            $this->parameters = [];
        }
        $this->parameters[] = $parameter;
        
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
        $route->setParameters($this->parameters);
        $route->setRoles($this->roles);
        
        return $route;
    }
}
