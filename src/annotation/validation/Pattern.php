<?php

namespace ndebugs\fall\annotation\validation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Pattern extends Validator {
    
    /**
     * @var string
     * @Required
     */
    public $value;
    
    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public function getDefaultMessage($name, $value) {
        return '\'' . $name . '\' must match with pattern: \'' . $this->value . '\'.';
    }
    
    public function validate($value) {
        return (boolean) preg_match('/' . $this->value . '/', $value);
    }
}
