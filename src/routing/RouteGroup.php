<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\net\Path;
use ndebugs\fall\reflection\MetaClass;

class RouteGroup {
    
    private $metadata;
    private $path;
    
    public function getMetadata() {
        return $this->metadata;
    }

    public function setMetadata(MetaClass $metadata) {
        $this->metadata = $metadata;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath(Path $path) {
        $this->path = $path;
    }
}
