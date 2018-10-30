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
        $type = null;
        $value = null;
        
        if (!$property->isPublic()) {
            $name = $property->getName();
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
        if ($adapter) {
            $valueType = $type != $defaultType ? $type : null;
            return $adapter->uncast($value, $valueType);
        } else {
            return $value;
        }
    }
    
    /**
     * @param MetaProperty $property
     * @param object $object
     * @param mixed $value
     * @return void
     */
    public function setValue(MetaProperty $property, $object, $value) {
        $type = $property->getType($this->context);
        
        $adapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $type, 'mixed');
        if ($adapter) {
            $valueType = $type != gettype($value) ? $type : null;
            $value = $adapter->uncast($value, $valueType);
        }
        
        if (!$property->isPublic()) {
            $name = $property->getName();
            $methodName = 'set' . ucfirst($name);
            if ($this->metadata->hasMethod($methodName)) {
                $method = $this->metadata->getMetaMethod($methodName);
                $method->invoke($object, $value);
            }
        } else {
            $property->setValue($object, $value);
        }
    }
    
    /**
     * @param array $values
     * @param object $object [optional]
     * @return object
     */
    public function toObject(array $values, $object = null) {
        if ($object === null) {
            $object = $this->metadata->newInstanceArgs();
        }
        
        $properties = $this->metadata->getMetaProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            if (array_key_exists($name, $values)) {
                $this->setValue($property, $object, $values[$name]);
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
