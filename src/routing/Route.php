<?php

namespace ndebugs\fall\routing;

use ReflectionMethod;
use ndebugs\fall\annotation\ResponseAttribute;
use ndebugs\fall\net\Path;

class Route {
    
    private $group;
    private $action;
    private $path;
    private $method;
    private $headers;
    private $requestAttributes;
    private $responseAttribute;
    private $roles;
    
    public function getGroup() {
        return $this->group;
    }

    public function setGroup(RouteGroup $group) {
        $this->group = $group;
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction(ReflectionMethod $action) {
        $this->action = $action;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath(Path $path) {
        $this->path = $path;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function setHeaders(array $headers = null) {
        $this->headers = $headers;
    }

    public function getRequestAttributes() {
        return $this->requestAttributes;
    }

    public function setRequestAttributes(array $requestAttributes = null) {
        $this->requestAttributes = $requestAttributes;
    }

    public function getResponseAttribute() {
        return $this->responseAttribute;
    }

    public function setResponseAttribute(ResponseAttribute $responseAttribute = null) {
        $this->responseAttribute = $responseAttribute;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function setRoles($roles) {
        $this->roles = $roles;
    }
}
