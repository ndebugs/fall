<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\context\ApplicationContext;

/** @TypeAdapter("mixed") */
class MixedAdapter extends BasicTypeAdapter {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return mixed
     */
    public function cast($value, $type = null) {
        if ($type !== null) {
            $adapter = class_exists($type) ?
                $this->context->getTypeAdapter(ObjectTypeAdapter::class, $type, 'object') :
                $this->context->getTypeAdapter(BasicTypeAdapter::class, $type);
            return $adapter ? $adapter->cast($value, $type) : $value;
        } else {
            return $value;
        }
    }
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return mixed
     */
    public function uncast($value, $type = null) {
        $valueType = is_object($value) ? get_class($value) : null;
        $adapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $valueType, gettype($value));
        
        return $adapter ? $adapter->uncast($value, $valueType) : $value;
    }
    
    /**
     * @param mixed $value
     * @param string $type [optional]
     * @return mixed
     */
    public function parse($value, $type = null) {
        if ($type !== null) {
            $adapter = $this->context->getTypeAdapter(BasicTypeAdapter::class, $type);
            return $adapter ? $adapter->parse($value, $type) : $value;
        } else {
            return $value;
        }
    }
    
    /**
     * @param mixed $value
     * @return string
     */
    public function toString($value) {
        $type = gettype($value);
        $adapter = $this->context->getTypeAdapter(BasicTypeAdapter::class, $type);
        $parsedValue = $adapter ? $adapter->parse($value, $type) : $value;
        return $parsedValue !== null ? (string) $parsedValue : null;
    }
}
