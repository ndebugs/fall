<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\http\HTTPRequest;
use ndebugs\fall\net\Path;

class PathEvaluator {
    
    /** @var HTTPRequest */
    private $request;
    
    /** @param HTTPRequest */
    public function __construct(HTTPRequest $request) {
        $this->request = $request;
    }

    /** @return HTTPRequest */
    public function getRequest() {
        return $this->request;
    }

	/**
	 * @param Path $path
	 * @param integer $offset
	 * @return string[]
	 */
    public function evaluate(Path $path, $offset) {
        $requestPath = $this->request->getURL()->getPath();
        
        $result = null;
        if ($requestPath->size() === $offset && $path->isEmpty()) {
            $result = [];
        } else {
            $index = $path->isAbsolute() ? 1 : 0;
            $result = $path->matches($requestPath, $offset, $index);
        }
        
        return $result;
    }
    
	/**
	 * @param Path $path
	 * @param integer $offset [optional]
	 * @return integer
	 */
    public function next(Path $path, $offset = 0) {
        $requestPath = $this->request->getURL()->getPath();
        if ($offset === 0 && $requestPath->isAbsolute()) {
            $offset = 1;
        }
        
        $index = $path->isAbsolute() ? 1 : 0;
        $length = $path->size() - $index;
        if ($path->matches($requestPath, $offset, $index, $length) !== null) {
            $lengthOffset = $path->isDirectory() ? 1 : 0;
            return $offset - $lengthOffset + $length;
        }
        
        return -1;
    }
}
