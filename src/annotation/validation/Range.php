<?php

namespace ndebugs\fall\annotation\validation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Range extends Validator {
    
    /** @var double */
    public $min = 0.0;
    
    /** @var double */
    public $max = -1.0;
    
    public function __construct(array $values) {
        if (!isset($values['value'])) {
            if (isset($values['min'])) {
                $this->min = $values['min'];
            }
            
            if (isset($values['max'])) {
                $this->max = $values['max'];
            }
        } else {
            $this->min = $this->max = $values['value'];
        }
    }
    
    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public function getDefaultMessage($name, $value) {
        if ($this->min == $this->max) {
            return '\'' . $name . '\' must equal with ' . $this->min . '.';
        } else if ($this->max > -1) {
            return '\'' . $name . '\' must between ' . $this->min . ' and ' . $this->max . '.';
        } else {
            return '\'' . $name . '\' must not less than ' . $this->min . '.';
        }
    }
    
    public function validate($value) {
        return $value >= $this->min &&
            ($this->max == -1 || $value <= $this->max);
    }
}
