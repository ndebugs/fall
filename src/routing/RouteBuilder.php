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
    
    /** @var RouteGroup */
    private $group;
    
    /** @var ReflectionMethod */
    private $action;
    
    /** @var Path */
    private $path;
    
    /** @var string */
    private $method;
    
    /** @var string[] */
    private $headers;
    
    /** @var RequestAttribute[] */
    private $requestAttributes;
    
    /** @var ResponseAttribute */
    private $responseAttribute;
    
    /** @var string[] */
    private $roles;
    
	/**
	 * @param RouteGroup $group
	 * @return RouteBuilder
	 */
    public function setGroup(RouteGroup $group) {
        $this->group = $group;
        
        return $this;
    }

	/**
	 * @param ReflectionMethod $action
	 * @return RouteBuilder
	 */
    public function setAction(ReflectionMethod $action) {
        $this->action = $action;
        
        return $this;
    }
    
	/**
	 * @param RequestMap $requestMap
	 * @return RouteBuilder
	 */
    public function setRequestMap(RequestMap $requestMap) {
        $this->path = Path::parseURL($requestMap->path);
        $this->method = $requestMap->method;
        $this->headers = $requestMap->headers;
        
        return $this;
    }
    
	/**
	 * @param RequestAttribute $attribute
	 * @return RouteBuilder
	 */
    public function addRequestAttribute(RequestAttribute $attribute) {
        if (!$this->requestAttributes) {
            $this->requestAttributes = [$attribute];
        } else {
            $this->requestAttributes[] = $attribute;
        }
        
        return $this;
    }
    
	/**
	 * @param ResponseAttribute $attribute
	 * @return RouteBuilder
	 */
    public function setResponseAttribute(ResponseAttribute $attribute) {
        $this->responseAttribute = $attribute;
        
        return $this;
    }
    
	/**
	 * @param Roles $roles [optional]
	 * @return RouteBuilder
	 */
    public function setRoles(Roles $roles = null) {
        $this->roles = $roles ? $roles->values : null;
        
        return $this;
    }
    
	/** @return Route */
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
