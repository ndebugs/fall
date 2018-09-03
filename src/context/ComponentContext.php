<?php

namespace ndebugs\fall\context;

use ReflectionClass;
use Doctrine\Common\Annotations\AnnotationReader;
use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\PostConstruct;

class ComponentContext {
    
    private $class;
    private $type;
    private $value;
    
    public function __construct($class, Component $type = null, $value = null) {
        $this->class = $class;
        $this->type = $type;
        $this->value = $value;
    }
    
    public function getClass() {
        return $this->class;
    }

    public function getType() {
        return $this->type;
    }

    public function getValue(ApplicationContext $context) {
        if (!$this->value) {
            $this->value = $this->loadValue($context);
        }
        
        return $this->value;
    }
    
    public function loadValue(ApplicationContext $context) {
        $reflection = new ReflectionClass($this->class);
        $instance = $reflection->newInstanceArgs();
        
        $reader = new AnnotationReader();
        
        foreach ($reflection->getProperties() as $property) {
            $annotation = $reader->getPropertyAnnotation($property, Autowired::class);
            if ($annotation) {
                $value = $context->getComponent($annotation->type);
                $property->setValue($instance, $value);
            }
        }
        
        foreach ($reflection->getMethods() as $method) {
            $annotation = $reader->getMethodAnnotation($method, PostConstruct::class);
            if ($annotation) {
                $method->invoke($instance);
                break;
            }
        }
        
        return $instance;
    }
}
