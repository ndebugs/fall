<?php

namespace ndebugs\fall\web;

class Template {
    
    private $name;
    private $parameters;
    
    public function __construct($name, array $parameters = null) {
        $this->name = $name;
        $this->parameters = $parameters;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    public function getParameter($key) {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
    }
    
    public function setParameter($key, $value) {
        if ($this->parameters === null) {
            $this->parameters = [$key => $value];
        } else {
            $this->parameters[$key] = $value;
        }
    }

    public function getParameters() {
        return $this->parameters;
    }
    
    public function setParameters(array $parameters = null) {
        $this->parameters = $parameters;
    }
}
