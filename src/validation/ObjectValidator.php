<?php

namespace ndebugs\fall\validation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\reflection\ObjectAccessor;
use ndebugs\fall\reflection\XProperty;

class ObjectValidator {
    
    /** @var ApplicationContext */
    private $context;
    
    /**
     * @param ApplicationContext $context
     */
    public function __construct(ApplicationContext $context) {
        $this->context = $context;
    }

    /**
     * @param XProperty $property
     * @param object $value
     * @return ValidationError
     */
    public function validateProperty(XProperty $property, $value) {
        $annotations = $property->getAnnotations($this->context, Validatable::class);
        foreach ($annotations as $annotation) {
            if (!$annotation->validate($value)) {
                return new ValidationError($annotation, $property->getName(), $value);
            }
        }
        
        return null;
    }
    
    /**
     * @param ObjectAccessor $object
     * @return void
     * 
     * @throws ValidationException
     */
    public function validate(ObjectAccessor $object) {
        $class = $object->getClass();
        $properties = $class->getProperties();
        $errors = [];
        foreach ($properties as $property) {
            $error = $this->validateProperty($property, $object->get($property));
            if ($error) {
                $errors[] = $error;
            }
        }
        
        if ($errors) {
            throw ValidationException::forErrors($errors);
        }
    }
}
