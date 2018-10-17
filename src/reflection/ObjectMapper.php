<?php

namespace ndebugs\fall\reflection;

use ndebugs\fall\adapter\DataTypeAdapter;
use ndebugs\fall\context\ApplicationContext;

class ObjectMapper {
    
    /** @var ApplicationContext */
    private $context;
    
    /** @var MetaClass */
    private $metadata;
    
    /**
     * @param ApplicationContext $context
     * @param MetaClass $metadata
     */
    public function __construct(ApplicationContext $context, MetaClass $metadata) {
        $this->context = $context;
        $this->metadata = $metadata;
    }

    /**
     * @param MetaProperty $property
     * @param object $object
     * @return mixed
     */
    public function getValue(MetaProperty $property, $object) {
        $name = $property->getName();
        $type = null;
        $value = null;
        
        if (!$property->isPublic()) {
            $methodName = 'get' . ucfirst($name);
            if ($this->metadata->hasMethod($methodName)) {
                $method = $this->metadata->getMetaMethod($methodName);
                $type = $method->getType($this->context);
                $value = $method->invoke($object);
            }
        } else {
            $value = $property->getValue($object);
        }
        
        if (!$type) {
            $type = $property->getType($this->context);
        }
        
        $defaultType = gettype($value);
        $adapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $type, $defaultType);
        $valueType = $type != $defaultType ? $type : null;
        return $adapter ? $adapter->uncast($value, $valueType) : $value;
    }
    
    /**
     * @param MetaProperty $property
     * @param object $object
     * @param mixed $value
     * @return void
     */
    public function setValue(MetaProperty $property, $object, $value) {
        $name = $property->getName();
        $type = $property->getType($this->context);
        
        $defaultType = gettype($value);
        $adapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $type, $defaultType);
        $valueType = $type != $defaultType ? $type : null;
        $adaptedValue = $adapter ? $adapter->cast($value, $valueType) : $value;
        
        if (!$property->isPublic()) {
            $methodName = 'set' . ucfirst($name);
            if ($this->metadata->hasMethod($methodName)) {
                $method = $this->metadata->getMetaMethod($methodName);
                $value = $method->invoke($object, $adaptedValue);
            }
        } else {
            $value = $property->setValue($object, $adaptedValue);
        }
    }
    
    /**
     * @param array $values
     * @return object
     */
    public function toObject(array $values) {
        $object = $this->metadata->newInstanceArgs();
        
        $properties = $this->metadata->getMetaProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            $value = isset($values[$name]) ? $values[$name] : null;
            
            if ($value !== null) {
                $this->setValue($property, $object, $value);
            }
        }
        
        return $object;
    }

    /**
     * @param object $object
     * @return array
     */
    public function toArray($object) {
        $values = [];
        $properties = $this->metadata->getMetaProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            $values[$name] = $this->getValue($property, $object);
        }
        
        return $values;
    }
}
