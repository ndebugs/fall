<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class DocumentTypeAdapter extends TypeAdapter {
    
    /** @var array<string> */
    public $types;
    
    public function hasType($type) {
        return in_array($type, $this->types, true);
    }
}
