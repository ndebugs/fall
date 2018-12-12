<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class StaticTypeAdapter extends Component {
    
    /**
     * @var string[]
     * @Required
     */
    public $types;
    
    /**
     * @param string $type
     * @return boolean
     */
    public function matches($type) {
        return in_array($type, $this->types, true);
    }
}
