<?php

namespace ndebugs\fall\component;

use Exception;
use ReflectionMethod;
use ReflectionParameter;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\reflection\XClass;
use ndebugs\fall\reflection\XMethod;

class ComponentLoader {
    
    /** @var XClass */
    private $class;
    
    /** @var Component */
    private $type;
    
    /**
     * @param XClass $class
     * @param Component $type
     */
    public function __construct(XClass $class, Component $type) {
        $this->class = $class;
        $this->type = $type;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return string
     */
    private function printParameterDefaultValue(ReflectionParameter $parameter) {
        if ($parameter->isDefaultValueAvailable()) {
            $defaultValue = $parameter->getDefaultValue();
            if (is_string($defaultValue)) {
                return '\'' . $defaultValue . '\'';
            } else if ($parameter->isDefaultValueConstant()) {
                return $parameter->getDefaultValueConstantName();
            } else if ($defaultValue === null) {
                return 'null';
            } else {
                return $defaultValue;
            }
        } else {
            return null;
        }
    }
    
    /**
     * @param ReflectionParameter $parameter
     * @return string
     */
    private function printParameter(ReflectionParameter $parameter) {
        $param = '';
        if ($parameter->hasType()) {
            $param .= $parameter->getType() . ' ';
        }
        if ($parameter->isPassedByReference()) {
            $param .= '&';
        }
        $param .= '$' . $parameter->getName();
        $defaultValue = $this->printParameterDefaultValue($parameter);
        if ($defaultValue !== null) {
            $param .= ' = ' . $defaultValue;
        }
        return $param;
    }
    
    /**
     * @param XMethod $method
     * @return string
     */
    private function printMethod(XMethod $method) {
        $name = $method->getName();
        $params = '';
        $parentParams = '';
        foreach ($method->getParameters() as $parameter) {
            if ($params) {
                $params .= ', ';
                $parentParams .= ', ';
            }
            
            $params .= $this->printParameter($parameter);
            $parentParams .= '$' . $parameter->getName();
        }
        return 'public function ' . $name . '(' . $params . ') {' .
            'try {' .
            '$this->__listener->onPreCall();' .
            '$result = parent::' . $name . '(' . $parentParams . ');' .
            '$this->__listener->onPostCall();' .
            '} catch (Exception $e) {' .
            '$this->__listener->onError($e);' .
            '}}';
    }
    
    /**
     * @param ComponentListener $listener [optional]
     * @return object
     */
    public function load(ComponentListener $listener = null) {
        if ($listener) {
            $parentName = $this->class->getName();
            $name = str_replace('\\', '_', $parentName) . 'Wrapper';
            $classBody = 'private $__listener;' .
                'public function __construct($__listener) {$this->__listener = $__listener;}';
            foreach ($this->class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                $classBody .= $this->printMethod($method);
            }
            
            eval('class ' . $name . ' extends ' . $parentName . ' {' . $classBody . '}');

            return new $name($listener);
        } else {
            return $this->class->newInstanceArgs();
        }
    }
}
