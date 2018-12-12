<?php

namespace ndebugs\fall\reflection\type;

use ndebugs\fall\reflection\XClass;

class ObjectType extends Type {
    
    const NAME = 'object';
    
    /** @var ObjectType[] */
    private static $instances = [];
    
    /** @var XClass */
    private $type;
    
    /** @param XClass $type */
    public function __construct(XClass $type = null) {
        parent::__construct(ObjectType::NAME);
        
        $this->type = $type;
    }
    
    /** @return XClass */
    public function getType() {
        return $this->type;
    }
    
    /**
     * @param XClass $type
     * @return integer
     */
    private function compareType(XClass $type = null) {
        if ($this->type == null) {
            return TypeComparable::GREATER_THAN;
        } else if ($type == null) {
            return TypeComparable::LESS_THAN;
        } else if (is_subclass_of($type->getName(), $this->type->getName())) {
            return TypeComparable::GREATER_THAN;
        } else if (is_subclass_of($this->type->getName(), $type->getName())) {
            return TypeComparable::LESS_THAN;
        }
        return TypeComparable::NOT_EQUAL;
    }
    
    /**
     * @param Type $type
     * @return integer
     */
    public function compare(Type $type) {
        if ($type instanceof ObjectType) {
            if ($this != $type) {
                return $this->compareType($type->getType());
            } else {
                return TypeComparable::EQUAL;
            }
        }
        return TypeComparable::NOT_EQUAL;
    }
    
    public function __toString() {
        return $this->type ? $this->type->getName() : parent::__toString();
    }
    
    /**
     * @param XClass $type [optional]
     * @return ObjectType
     */
    public static function getInstance(XClass $type = null) {
        $key = $type ? $type->getName() : null;
        if (!isset(ObjectType::$instances[$key])) {
            return ObjectType::$instances[$key] = new ObjectType($type);
        } else {
            return ObjectType::$instances[$key];
        }
    }
}
