<?php

namespace ndebugs\fall\reflection;

use ndebugs\fall\adapter\DataTypeAdaptable;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\validation\ObjectValidator;
use ndebugs\fall\validation\ValidationError;
use ndebugs\fall\validation\ValidationException;

class ObjectMapper {
    
    /** @var ApplicationContext */
    private $context;
    
    /** @var XClass */
    private $class;
    
    /** @var ObjectValidator */
    private $validator;
    
    /**
     * @param ApplicationContext $context
     * @param XClass $class
     */
    public function __construct(ApplicationContext $context, XClass $class) {
        $this->context = $context;
        $this->class = $class;
        
        $this->validator = new ObjectValidator($context);
    }

    /**
     * @param XProperty $property
     * @param ObjectAccessor $object
     * @return mixed
     */
    public function getValue(XProperty $property, ObjectAccessor $object) {
        $type = $property->getType($this->context);
        $adapter = $this->context->getTypeAdapter(DataTypeAdaptable::class, $type);
        
        $value = $object->get($property);
        return $adapter ? $adapter->uncast($value, $type) : $value;
    }
    
    /**
     * @param XProperty $property
     * @param ObjectAccessor $object
     * @param mixed $value
     * @return ValidationError
     */
    public function setValue(XProperty $property, ObjectAccessor $object, $value) {
        $type = $property->getType($this->context);
        $adapter = $this->context->getTypeAdapter(DataTypeAdaptable::class, $type);
        if ($adapter) {
            $value = $adapter->cast($value, $type);
        }
        
        $error = $this->validator->validateProperty($property, $value);
        if (!$error) {
            $object->set($property, $value);
        }
        return $error;
    }
    
    /**
     * @param array $values
     * @param object $object [optional]
     * @return object
     * 
     * @throws ValidationException
     */
    public function toObject(array $values, $object = null) {
        if ($object === null) {
            $object = $this->class->newInstanceArgs();
        }
        $objectAccessor = new ObjectAccessor($object, $this->class);
        
        $errors = [];
        $properties = $this->class->getProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            $error = array_key_exists($name, $values) ?
                $this->setValue($property, $objectAccessor, $values[$name]) :
                $this->validator->validateProperty($property, null);
            if ($error) {
                $errors[] = $error;
            }
        }
        
        if ($errors) {
            throw ValidationException::forErrors($errors);
        }
        return $object;
    }

    /**
     * @param object $object
     * @return array
     */
    public function toArray($object) {
        $objectAccessor = new ObjectAccessor($object, $this->class);
        
        $values = [];
        $properties = $this->class->getProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            $values[$name] = $this->getValue($property, $objectAccessor);
        }
        
        return $values;
    }
}
