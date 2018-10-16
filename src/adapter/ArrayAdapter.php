<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\context\ApplicationContext;

/** @TypeAdapter("array") */
class ArrayAdapter extends BasicTypeAdapter {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @param string $type
     * @return DataTypeAdapter
     */
    public function getAdapter($type) {
        return class_exists($type) ?
            $this->context->getTypeAdapter(ObjectTypeAdapter::class, $type, 'object') :
            $this->context->getTypeAdapter(BasicTypeAdapter::class, $type);
    }
    
    /**
     * @param array $value
     * @param string $type [optional]
     * @return array
     */
    public function cast($value, $type = null) {
        if ($value !== null) {
            $adapter = null;
            if ($type !== null) {
                $type = preg_replace('/\[\]$/', '', $type);
                $adapter = $this->getAdapter($type);
            }

            $values = [];
            foreach ($value as $k => $v) {
                if (!$adapter) {
                    $valueType = is_object($v) ? get_class($v) : null;
                    $valueAdapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $valueType, gettype($v));
                    $values[$k] = $valueAdapter->cast($v, $valueType);
                } else {
                    $values[$k] = $adapter->cast($v, $type);
                }
            }
            return $values;
        } else {
            return null;
        }
    }
    
    /**
     * @param array $value
     * @param string $type [optional]
     * @return array
     */
    public function uncast($value, $type = null) {
        if ($value !== null) {
            $adapter = null;
            if ($type !== null) {
                $type = preg_replace('/\[\]$/', '', $type);
                $adapter = $this->getAdapter($type);
            }

            $values = [];
            foreach ($value as $k => $v) {
                if (!$adapter) {
                    $valueType = is_object($v) ? get_class($v) : null;
                    $valueAdapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $valueType, gettype($v));
                    $values[$k] = $valueAdapter->uncast($v, $valueType);
                } else {
                    $values[$k] = $adapter->uncast($v, $type);
                }
            }
            return $values;
        } else {
            return null;
        }
    }
    
    /**
     * @param array $value
     * @param string $type [optional]
     * @return array
     */
    public function parse($value, $type = null) {
        return null;
    }
    
    /**
     * @param array $value
     * @return string
     */
    public function toString($value) {
        return null;
    }
}
