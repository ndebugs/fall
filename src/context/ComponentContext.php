<?php

namespace ndebugs\fall\context;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\reflection\XClass;

class ComponentContext {
    
    /** @var Component */
    private $type;
    
    /** @var XClass */
    private $reflection;
    
    /** @var object */
    private $value;
    
    /**
     * @param XClass $reflection
     * @param object $value [optional]
     */
    public function __construct(XClass $reflection, $value = null) {
        $this->reflection = $reflection;
        $this->value = $value;
    }
    
    /** @return ApplicationContext */
    public function getContext() {
        return $this->context;
    }

    /** @return Component */
    public function getType(ApplicationContext $context) {
        if (!$this->type) {
            $this->type = $this->reflection->getAnnotation($context, Component::class);
        }
        
        return $this->type;
    }

    /** @return XClass */
    public function getReflection() {
        return $this->reflection;
    }

    /** @return object */
    public function getValue(ApplicationContext $context) {
        if (!$this->value) {
            $this->value = $this->loadValue($context);
        }
        
        return $this->value;
    }
    
    /** @return object */
    public function loadValue(ApplicationContext $context) {
        $instance = $this->reflection->newInstanceArgs();
        
        foreach ($this->reflection->getProperties() as $property) {
            $annotation = $property->getAnnotation($context, Autowired::class);
            if ($annotation) {
                $type = $property->getType($context);
                $value = $context->getComponent((string) $type);
                $property->setValue($instance, $value);
            }
        }
        
        foreach ($this->reflection->getMethods() as $method) {
            $annotation = $method->getAnnotation($context, PostConstruct::class);
            if ($annotation) {
                $method->invoke($instance);
                break;
            }
        }
        
        return $instance;
    }
}
