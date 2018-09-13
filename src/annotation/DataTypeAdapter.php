<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class DataTypeAdapter extends TypeAdapter {
    
    /** @var string */
    public $type;
    
    public function hasType($type) {
        return $this->type == $type;
    }
}
