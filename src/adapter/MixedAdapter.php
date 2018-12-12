<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\reflection\TypeResolver;
use ndebugs\fall\reflection\type\Type;
use ndebugs\fall\reflection\type\AnyType;

/** @TypeAdapter(AnyType::NAME) */
class MixedAdapter implements BasicTypeAdaptable {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @param mixed $value
     * @param Type $type [optional]
     * @return mixed
     */
    public function cast($value, Type $type = null) {
        if ($type && !$type instanceof AnyType) {
            $adapter = $this->context->getTypeAdapter(DataTypeAdaptable::class, $type);
            return $adapter ? $adapter->cast($value, $type) : $value;
        } else {
            return $value;
        }
    }
    
    /**
     * @param mixed $value
     * @param Type $type [optional]
     * @return mixed
     */
    public function uncast($value, Type $type = null) {
        $resolvedType = $type && !$type instanceof AnyType ?
                $type : TypeResolver::fromValue($value);
        $adapter = $this->context->getTypeAdapter(DataTypeAdaptable::class, $resolvedType);
        return $adapter ? $adapter->uncast($value, $resolvedType) : $value;
    }
    
    /**
     * @param string $value
     * @return string
     */
    public function parse($value) {
        return $value;
    }
    
    /**
     * @param mixed $value
     * @return string
     */
    public function toString($value) {
        $type = TypeResolver::fromValue($value);
        $adapter = $this->context->getTypeAdapter(BasicTypeAdaptable::class, $type);
        return $adapter ? $adapter->toString($value) : (string) $value;
    }
}
