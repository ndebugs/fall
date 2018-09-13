<?php

namespace ndebugs\fall\web;

class TypedModel {
    
    private $type;
    private $value;
    
    public function __construct($type, $value) {
        $this->type = $type;
        $this->value = $value;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
}
