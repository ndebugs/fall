<?php

namespace ndebugs\fall\context;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\component\ComponentLoader;
use ndebugs\fall\reflection\XClass;

class ComponentContext {
    
    /** @var Component */
    private $type;
    
    /** @var XClass */
    private $class;
    
    /** @var object */
    private $value;
    
    /**
     * @param XClass $class
     * @param object $value [optional]
     */
    public function __construct(XClass $class, $value = null) {
        $this->class = $class;
        $this->value = $value;
    }
    
    /** @return ApplicationContext */
    public function getContext() {
        return $this->context;
    }

    /** @return Component */
    public function getType(ApplicationContext $context) {
        if (!$this->type) {
            $this->type = $this->class->getAnnotation($context, Component::class);
        }
        
        return $this->type;
    }

    /** @return XClass */
    public function getClass() {
        return $this->class;
    }

    /** @return object */
    public function getValue(ApplicationContext $context) {
        if (!$this->value) {
            $type = $this->getType($context);
            $listenerClass = $type->getListenerClass();
            $listener = $listenerClass ? $listenerClass->newInstanceArgs() : null;
            
            $loader = new ComponentLoader($this->class, $this->getType($context));
            $value = $loader->load($listener);
            
            $this->initProperties($context, $value);
            $this->initMethods($context, $value);
            
            $this->value = $value;
        }
        
        return $this->value;
    }
    
    /**
     * @param ApplicationContext $context
     * @param object $object
     * @return void
     */
    private function initProperties(ApplicationContext $context, $object) {
        foreach ($this->class->getProperties() as $property) {
            $annotation = $property->getAnnotation($context, Autowired::class);
            if ($annotation) {
                $type = $property->getType($context);
                $value = $context->getComponent((string) $type);
                $property->setValue($object, $value);
            }
        }
    }
    
    /**
     * @param ApplicationContext $context
     * @param object $object
     * @return void
     */
    private function initMethods(ApplicationContext $context, $object) {
        foreach ($this->class->getMethods() as $method) {
            $annotation = $method->getAnnotation($context, PostConstruct::class);
            if ($annotation) {
                $method->invoke($object);
                break;
            }
        }
    }
}
