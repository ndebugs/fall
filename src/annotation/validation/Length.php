<?php

namespace ndebugs\fall\annotation\validation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Length extends Validator {
    
    /** @var integer */
    public $min = 0;
    
    /** @var integer */
    public $max = -1;
    
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
            return '\'' . $name . '\' length must equal with ' . $this->min . '.';
        } else if ($this->max > -1) {
            return '\'' . $name . '\' length must between ' . $this->min . ' and ' . $this->max . '.';
        } else {
            return '\'' . $name . '\' length cannot less than ' . $this->min . '.';
        }
    }
    
    public function validate($value) {
        $length = strlen($value);
        return $length >= $this->min &&
            ($this->max == -1 || $length <= $this->max);
    }
}
