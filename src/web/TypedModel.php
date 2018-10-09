<?php

namespace ndebugs\fall\web;

class TypedModel {
    
    /** @var string */
    private $type;
    
    /** @var object */
    private $value;
    
    /**
     * @param string $type
     * @param object $value
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

    /** @return object */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param object $value
     * @return void
     */
    public function setValue($value) {
        $this->value = $value;
    }
}
