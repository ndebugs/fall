<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\net\Path;

class RouteGroup {
    
    private $controller;
    private $path;
    
    public function getController() {
        return $this->controller;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath(Path $path) {
        $this->path = $path;
    }
}
