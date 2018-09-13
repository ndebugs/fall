<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class ResponseFilter extends TypeFilter {
    
    /**
     * @var string
     * @Required
     */
    public $type;
    
    public function matchType($value) {
        return is_object($value) ?
            $value instanceof $this->type : gettype($value) == $this->type;
    }
}
