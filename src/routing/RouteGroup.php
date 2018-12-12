<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\net\Path;
use ndebugs\fall\reflection\XClass;

class RouteGroup {
    
    /** @var XClass */
    private $controller;
    
    /** @var Path */
    private $path;
    
    /** @return XClass */
    public function getController() {
        return $this->controller;
    }

	/**
	 * @param XClass $controller
	 * @return void
	 */
    public function setController(XClass $controller) {
        $this->controller = $controller;
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
}
