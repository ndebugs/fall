<?php

namespace ndebugs\fall\annotation\validation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class NotNull extends Validator {
    
    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public function getDefaultMessage($name, $value) {
        return '\'' . $name . '\' cannot null.';
    }
    
    public function validate($value) {
        return $value !== null;
    }
}
