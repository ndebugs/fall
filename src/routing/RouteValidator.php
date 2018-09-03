<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\net\HTTPRequest;
use ndebugs\fall\routing\Route;

class RouteValidator {
    
    private $route;
    
    public function __construct(Route $route) {
        $this->route = $route;
    }

    public function validateMethod(HTTPRequest $request) {
        return $request->getMethod() === $this->route->getMethod();
    }

    public function validateHeader(HTTPRequest $request) {
        $headers = $this->route->getHeaders();
        if ($headers) {
            foreach ($headers as $key => $value) {
                $requestValue = $request->getHeader($key);
                if ($value !== $requestValue) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    public static function validateAll(Route $route, HTTPRequest $request) {
        $validator = new RouteValidator($route);
        return $validator->validateMethod($request) &&
                $validator->validateHeader($request);
    }
}
