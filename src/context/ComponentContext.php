<?php

namespace ndebugs\fall\context;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\reflection\MetaClass;

class ComponentContext {
    
    private $context;
    private $type;
    private $reflection;
    private $value;
    
    public function __construct(ApplicationContext $context, MetaClass $reflection, $value = null) {
        $this->context = $context;
        $this->reflection = $reflection;
        $this->value = $value;
    }
    
    public function getContext() {
        return $this->context;
    }

    public function getType() {
        if (!$this->type) {
            $this->type = $this->reflection->getAnnotation($this->context, Component::class);
        }
        
        return $this->type;
    }

    public function getReflection() {
        return $this->reflection;
    }

    public function getValue() {
        if (!$this->value) {
            $this->value = $this->loadValue();
        }
        
        return $this->value;
    }
    
    public function loadValue() {
        $instance = $this->reflection->newInstanceArgs();
        
        foreach ($this->reflection->getMetaProperties() as $property) {
            $annotation = $property->getAnnotation($this->context, Autowired::class);
            if ($annotation) {
                $value = $this->context->getComponent($property->getType($this->context));
                $property->setValue($instance, $value);
            }
        }
        
        foreach ($this->reflection->getMetaMethods() as $method) {
            $annotation = $method->getAnnotation($this->context, PostConstruct::class);
            if ($annotation) {
                $method->invoke($instance);
                break;
            }
        }
        
        return $instance;
    }
}
