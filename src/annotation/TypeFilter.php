<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class TypeFilter extends Component {
    
    /**
     * @var string
     * @Required
     */
    public $type;
    
    /**
     * @param mixed $value
     * @return boolean
     */
    public function matchType($value) {
        return is_object($value) ?
            $value instanceof $this->type : gettype($value) == $this->type;
    }
}
