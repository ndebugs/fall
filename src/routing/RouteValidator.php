<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\http\HTTPRequest;
use ndebugs\fall\routing\Route;

class RouteValidator {
    
    /** @var Route */
    private $route;
    
    /** @param Route $route */
    public function __construct(Route $route) {
        $this->route = $route;
    }

	/**
	 * @param HTTPRequest $request
	 * @return boolean
	 */
    public function validateMethod(HTTPRequest $request) {
        return $request->getMethod() === $this->route->getMethod();
    }

	/**
	 * @param HTTPRequest $request
	 * @return boolean
	 */
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
    
	/**
	 * @param Route $route
	 * @param HTTPRequest $request
	 * @return boolean
	 */
    public static function validateAll(Route $route, HTTPRequest $request) {
        $validator = new RouteValidator($route);
        return $validator->validateMethod($request) &&
                $validator->validateHeader($request);
    }
}
