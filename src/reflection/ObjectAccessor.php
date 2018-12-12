<?php

namespace ndebugs\fall\reflection;

class ObjectAccessor {
    
    /** @var object */
    private $object;
    
    /** @var XClass */
    private $class;
    
    /**
     * @param object $object
     * @param XClass $class
     */
    public function __construct($object, XClass $class) {
        $this->object = $object;
        $this->class = $class;
    }
    
    /** @return object */
    public function getObject() {
        return $this->object;
    }

    /** @return XClass */
    public function getClass() {
        return $this->class;
    }

    /**
     * @param XProperty $property
     * @return mixed
     */
    public function get(XProperty $property) {
        if (!$property->isPublic()) {
            $name = $property->getName();
            $methodName = 'get' . ucfirst($name);
            if ($this->class->hasMethod($methodName)) {
                $method = $this->class->getMethod($methodName);
                return $method->invoke($this->object);
            }
        } else {
            return $property->getValue($this->object);
        }
        
        return null;
    }
    
    /**
     * @param XProperty $property
     * @param mixed $value
     * @return mixed
     */
    public function set(XProperty $property, $value) {
        if (!$property->isPublic()) {
            $name = $property->getName();
            $methodName = 'set' . ucfirst($name);
            if ($this->class->hasMethod($methodName)) {
                $method = $this->class->getMethod($methodName);
                $method->invoke($this->object, $value);
                return $value;
            }
        } else {
            $property->setValue($this->object, $value);
            return $value;
        }
        
        return null;
    }
}
