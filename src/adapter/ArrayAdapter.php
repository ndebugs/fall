<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\reflection\TypeResolver;
use ndebugs\fall\reflection\type\Type;
use ndebugs\fall\reflection\type\ArrayType;

/** @TypeAdapter(ArrayType::NAME) */
class ArrayAdapter implements DataTypeAdaptable {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @param array $value
     * @param Type $type [optional]
     * @return array
     */
    public function cast($value, Type $type = null) {
        if ($type instanceof ArrayType && $type->getType()) {
            $adapter = $this->context->getTypeAdapter(DataTypeAdaptable::class, $type->getType());
            if ($adapter) {
                $values = [];
                foreach ($value as $k => $v) {
                    $values[$k] = $adapter->cast($v, $type->getType());
                }
                return $values;
            }
        }
        return is_array($value) ? $value : null;
    }
    
    /**
     * @param array $value
     * @param Type $type [optional]
     * @return array
     */
    public function uncast($value, Type $type = null) {
        if ($value !== null) {
            $adapter = null;
            if ($type instanceof ArrayType && $type->getType()) {
                $adapter = $this->context->getTypeAdapter(DataTypeAdaptable::class, $type->getType());
            }

            $values = [];
            foreach ($value as $k => $v) {
                if (!$adapter) {
                    $valueType = TypeResolver::fromValue($v);
                    $valueAdapter = $this->context->getTypeAdapter(DataTypeAdaptable::class, $valueType);
                    $values[$k] = $valueAdapter->uncast($v, $valueType);
                } else {
                    $values[$k] = $adapter->uncast($v, $type->getType());
                }
            }
            return $values;
        } else {
            return null;
        }
    }
}
