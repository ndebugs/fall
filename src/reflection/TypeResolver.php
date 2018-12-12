<?php

namespace ndebugs\fall\reflection;

use ndebugs\fall\reflection\type\AnyType;
use ndebugs\fall\reflection\type\ArrayType;
use ndebugs\fall\reflection\type\BooleanType;
use ndebugs\fall\reflection\type\DecimalType;
use ndebugs\fall\reflection\type\IntegerType;
use ndebugs\fall\reflection\type\NullType;
use ndebugs\fall\reflection\type\ObjectType;
use ndebugs\fall\reflection\type\StringType;
use phpDocumentor\Reflection\Type as T;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;

final class TypeResolver {
    
    private function __construct() {}
    
    /**
     * @param string $value
     * @return Type
     */
    public static function fromString($value) {
        switch ($value) {
            case AnyType::NAME:
                return AnyType::getInstance();
            case BooleanType::NAME:
                return BooleanType::getInstance();
            case IntegerType::NAME:
                return IntegerType::getInstance();
            case DecimalType::NAME:
                return DecimalType::getInstance();
            case StringType::NAME:
                return StringType::getInstance();
            case ArrayType::NAME:
                return ArrayType::getInstance();
            case ObjectType::NAME:
                return ObjectType::getInstance();
        }
        
        $matches = array();
        if (preg_match('/(.*)\[\]$/', $value, $matches)) {
            $subType = TypeResolver::fromString($matches[1]);
            return ArrayType::getInstance($subType);
        } else if (class_exists($value)) {
            $subType = new XClass($value);
            return ObjectType::getInstance($subType);
        } else {
            return NullType::getInstance();
        }
    }

    /**
     * @param mixed $value
     * @return Type
     */
    public static function fromValue($value) {
        $type = is_object($value) ? get_class($value) : gettype($value);
        return TypeResolver::fromString($type);
    }
    
    /**
     * @param T $value
     * @return Type
     */
    public static function fromType(T $value) {
        if ($value === null || $value instanceof Mixed_) {
            return AnyType::getInstance();
        } else if ($value instanceof Boolean) {
            return BooleanType::getInstance();
        } else if ($value instanceof Integer) {
            return IntegerType::getInstance();
        } else if ($value instanceof Float_) {
            return DecimalType::getInstance();
        } else if ($value instanceof String_) {
            return StringType::getInstance();
        } else if ($value instanceof Array_) {
            $subType = TypeResolver::fromType($value->getValueType());
            return ArrayType::getInstance($subType);
        } else if ($value instanceof Object_) {
            $fqsen = $value->getFqsen();
            $subType = $fqsen ? new XClass(substr($fqsen, 1)) : null;
            return ObjectType::getInstance($subType);
        } else {
            return NullType::getInstance();
        }
    }
}
