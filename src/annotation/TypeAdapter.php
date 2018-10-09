<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class TypeAdapter extends Component {
    
    /** @var string[] */
    public $types;
    
    /**
     * @param string $type
     * @return boolean
     */
    public function hasType($type) {
        return in_array($type, $this->types, true);
    }
}
