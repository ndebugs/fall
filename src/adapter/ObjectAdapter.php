<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\reflection\MetaClass;
use ndebugs\fall\reflection\ObjectMapper;

/** @TypeAdapter("object") */
class ObjectAdapter extends ObjectTypeAdapter {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @param array $value
     * @param string $type [optional]
     * @return object
     */
    public function cast($value, $type = null) {
        if (class_exists($type)) {
            $metadata = new MetaClass($type);
            $mapper = new ObjectMapper($this->context, $metadata);
            return $mapper->toObject($value);
        } else {
            return null;
        }
    }
    
    /**
     * @param object $value
     * @param string $type [optional]
     * @return array
     */
    public function uncast($value, $type = null) {
        if (is_object($value)) {
            $metadata = new MetaClass($value);
            $mapper = new ObjectMapper($this->context, $metadata);
            return $mapper->toArray($value);
        } else {
            return null;
        }
    }
}
