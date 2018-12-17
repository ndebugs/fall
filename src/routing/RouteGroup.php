<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\net\Path;
use ndebugs\fall\reflection\XClass;

class RouteGroup {
    
    /** @var XClass */
    private $class;
    
    /** @var Path */
    private $path;
    
    /** @return XClass */
    public function getClass() {
        return $this->class;
    }

	/**
	 * @param XClass $class
	 * @return void
	 */
    public function setClass(XClass $class) {
        $this->class = $class;
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
