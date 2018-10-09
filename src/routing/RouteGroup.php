<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\net\Path;
use ndebugs\fall\reflection\MetaClass;

class RouteGroup {
    
    /** @var MetaClass */
    private $metadata;
    
    /** @var Path */
    private $path;
    
    /** @return MetaClass */
    public function getMetadata() {
        return $this->metadata;
    }

	/**
	 * @param MetaClass $metadata
	 * @return void
	 */
    public function setMetadata(MetaClass $metadata) {
        $this->metadata = $metadata;
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
