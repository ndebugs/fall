<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\reflection\XClass;
use ndebugs\fall\reflection\ObjectMapper;
use ndebugs\fall\reflection\type\Type;
use ndebugs\fall\reflection\type\ObjectType;

/** @TypeAdapter(ObjectType::NAME) */
class ObjectAdapter implements ObjectTypeAdaptable {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @param array $value
     * @param Type $type [optional]
     * @return object
     */
    public function cast($value, Type $type = null) {
        if ($type instanceof ObjectType && $type->getType()) {
            $mapper = new ObjectMapper($this->context, $type->getType());
            return $mapper->toObject($value);
        } else {
            return null;
        }
    }
    
    /**
     * @param object $value
     * @param Type $type [optional]
     * @return array
     */
    public function uncast($value, Type $type = null) {
        if (is_object($value)) {
            $class = $type instanceof ObjectType && $type->getType() ?
                    $type->getType() : new XClass($value);
            $mapper = new ObjectMapper($this->context, $class);
            return $mapper->toArray($value);
        } else {
            return null;
        }
    }
}
