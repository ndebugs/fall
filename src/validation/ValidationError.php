<?php

namespace ndebugs\fall\validation;

class ValidationError {
    
    /** @var Validatable */
    private $validatable;
    
    /** @var string */
    private $name;
    
    /** @var mixed */
    private $value;
    
    /**
     * @param Validatable $validatable
     * @param string $name
     * @param mixed $value
     */
    public function __construct(Validatable $validatable, $name, $value) {
        $this->validatable = $validatable;
        $this->name = $name;
        $this->value = $value;
    }

    /** @return Validatable */
    public function getValidatable() {
        return $this->validatable;
    }
    
    /** @return string */
    public function getName() {
        return $this->name;
    }

    /** @return mixed */
    public function getValue() {
        return $this->value;
    }
}
