<?php

namespace ndebugs\fall\net;

class PathSegment {
    
    const VARIABLE_PATTERN = '/^{(.*)}$/';
    
    private $name;
    private $variable;
    
    private function __construct($name, $variable = false) {
        $this->name = $name;
        $this->variable = $variable;
    }
    
    public function getName() {
        return $this->name;
    }

    public function isEmpty() {
        return $this->name === '';
    }

    public function isVariable() {
        return $this->variable;
    }

    public function __toString() {
        return $this->variable ? '{' . $this->name . '}' : $this->name;
    }
    
    public static function parse($name) {
        $matches = array();
        return preg_match(PathSegment::VARIABLE_PATTERN, $name, $matches) ?
                new PathSegment($matches[1], true) : new PathSegment($name);
    }
}
