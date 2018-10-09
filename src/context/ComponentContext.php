<?php

namespace ndebugs\fall\context;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\reflection\MetaClass;

class ComponentContext {
    
    /** @var Component */
    private $type;
    
    /** @var MetaClass */
    private $metadata;
    
    /** @var object */
    private $value;
    
    /**
     * @param MetaClass $metadata
     * @param object $value [optional]
     */
    public function __construct(MetaClass $metadata, $value = null) {
        $this->metadata = $metadata;
        $this->value = $value;
    }
    
    /** @return ApplicationContext */
    public function getContext() {
        return $this->context;
    }

    /** @return Component */
    public function getType(ApplicationContext $context) {
        if (!$this->type) {
            $this->type = $this->metadata->getAnnotation($context, Component::class);
        }
        
        return $this->type;
    }

    /** @return MetaClass */
    public function getMetadata() {
        return $this->metadata;
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
        $instance = $this->metadata->newInstanceArgs();
        
        foreach ($this->metadata->getMetaProperties() as $property) {
            $annotation = $property->getAnnotation($context, Autowired::class);
            if ($annotation) {
                $value = $context->getComponent($property->getType($context));
                $property->setValue($instance, $value);
            }
        }
        
        foreach ($this->metadata->getMetaMethods() as $method) {
            $annotation = $method->getAnnotation($context, PostConstruct::class);
            if ($annotation) {
                $method->invoke($instance);
                break;
            }
        }
        
        return $instance;
    }
}
