<?php

namespace ndebugs\fall\web;

class Template {
    
    /** @var string */
    private $name;
    
    /** @var array */
    private $parameters;
    
    /**
     * @param string $name
     * @param array $parameters [optional]
     */
    public function __construct($name, array $parameters = null) {
        $this->name = $name;
        $this->parameters = $parameters;
    }
    
    /** @return string */
    public function getName() {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return void
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getParameter($key) {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setParameter($key, $value) {
        if ($this->parameters === null) {
            $this->parameters = [$key => $value];
        } else {
            $this->parameters[$key] = $value;
        }
    }

    /** @return array */
    public function getParameters() {
        return $this->parameters;
    }
    
    /**
     * @param array $parameters [optional]
     * @return void
     */
    public function setParameters(array $parameters = null) {
        $this->parameters = $parameters;
    }
}
