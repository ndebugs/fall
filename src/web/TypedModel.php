<?php

namespace ndebugs\fall\web;

class TypedModel {
    
    /** @var string */
    private $type;
    
    /** @var mixed */
    private $value;
    
    /**
     * @param string $type
     * @param mixed $value
     */
    public function __construct($type, $value) {
        $this->type = $type;
        $this->value = $value;
    }
    
    /** @return string */
    public function getType() {
        return $this->type;
    }
    
    /**
     * @param string $type
     * @return void
     */
    public function setType($type) {
        $this->type = $type;
    }

    /** @return mixed */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue($value) {
        $this->value = $value;
    }
}
