<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\annotation\RequestAttribute;
use ndebugs\fall\annotation\ResponseAttribute;
use ndebugs\fall\net\Path;
use ndebugs\fall\reflection\XMethod;

class Route {
    
    /** @var RouteGroup */
    private $group;
    
    /** @var XMethod */
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
    
    /** @return RouteGroup */
    public function getGroup() {
        return $this->group;
    }

	/**
	 * @param RouteGroup $group
	 * @return void
	 */
    public function setGroup(RouteGroup $group) {
        $this->group = $group;
    }

    /** @return XMethod */
    public function getAction() {
        return $this->action;
    }

	/**
	 * @param XMethod $action
	 * @return void
	 */
    public function setAction(XMethod $action) {
        $this->action = $action;
    }

    /** @return Path */
    public function getPath() {
        return $this->path;
    }

	/**
	 * @param Path $path
	 * @return void
	 */
    public function setPath(Path $path) {
        $this->path = $path;
    }

    /** @return string */
    public function getMethod() {
        return $this->method;
    }

	/**
	 * @param string $method
	 * @return void
	 */
    public function setMethod($method) {
        $this->method = $method;
    }

    /** @return string[] */
    public function getHeaders() {
        return $this->headers;
    }

	/**
	 * @param string[] $headers [optional]
	 * @return void
	 */
    public function setHeaders(array $headers = null) {
        $this->headers = $headers;
    }

    /** @return RequestAttribute[] */
    public function getRequestAttributes() {
        return $this->requestAttributes;
    }

	/**
	 * @param RequestAttribute[] $requestAttributes [optional]
	 * @return void
	 */
    public function setRequestAttributes(array $requestAttributes = null) {
        $this->requestAttributes = $requestAttributes;
    }

    /** @return ResponseAttribute */
    public function getResponseAttribute() {
        return $this->responseAttribute;
    }

	/**
	 * @param ResponseAttribute $responseAttribute [optional]
	 * @return void
	 */
    public function setResponseAttribute(ResponseAttribute $responseAttribute = null) {
        $this->responseAttribute = $responseAttribute;
    }

    /** @return string[] */
    public function getRoles() {
        return $this->roles;
    }

	/**
	 * @param string[] $roles
	 * @return void
	 */
    public function setRoles($roles) {
        $this->roles = $roles;
    }
}
