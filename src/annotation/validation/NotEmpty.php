<?php

namespace ndebugs\fall\annotation\validation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class NotEmpty extends Validator {
    
    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public function getDefaultMessage($name, $value) {
        return '\'' . $name . '\' cannot empty.';
    }
    
    public function validate($value) {
        return !empty($value);
    }
}
