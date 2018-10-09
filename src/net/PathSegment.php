<?php

namespace ndebugs\fall\net;

class PathSegment {
    
    const VARIABLE_PATTERN = '/^{(.*)}$/';
    
    /** @var string */
    private $name;
    
    /** @var boolean */
    private $variable;
    
    /**
     * @param string
     * @param boolean $variable [optional]
     */
    private function __construct($name, $variable = false) {
        $this->name = $name;
        $this->variable = $variable;
    }
    
    /** @return string */
    public function getName() {
        return $this->name;
    }

    /** @return boolean */
    public function isEmpty() {
        return $this->name === '';
    }

    /** @return boolean */
    public function isVariable() {
        return $this->variable;
    }

    /** @return string */
    public function __toString() {
        return $this->variable ? '{' . $this->name . '}' : $this->name;
    }
    
    /**
     * @param string $name
     * @return PathSegment
     */
    public static function parse($name) {
        $matches = array();
        return preg_match(PathSegment::VARIABLE_PATTERN, $name, $matches) ?
                new PathSegment($matches[1], true) : new PathSegment($name);
    }
}
