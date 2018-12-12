<?php

namespace ndebugs\fall\reflection\type;

class ArrayType extends Type {
    
    const NAME = 'array';
    
    /** @var ArrayType[] */
    private static $instances = [];
    
    /** @var Type */
    private $type;
    
    /** @param Type $type */
    public function __construct(Type $type = null) {
        parent::__construct(ArrayType::NAME);
        
        $this->type = $type;
    }
    
    /** @return Type */
    public function getType() {
        return $this->type;
    }
    
    /**
     * @param Type $type
     * @return integer
     */
    public function compare(Type $type) {
        if ($type instanceof ArrayType) {
            if ($this == $type) {
                return 1;
            } else if ($this->type && $type->getType()) {
                return $this->type->compare($type->getType());
            }
        }
        return TypeComparable::NOT_EQUAL;
    }
    
    public function __toString() {
        return $this->type ? $this->type . '[]' : parent::__toString();
    }

    /**
     * @param Type $type [optional]
     * @return ArrayType
     */
    public static function getInstance(Type $type = null) {
        if (!isset(ArrayType::$instances[$type])) {
            return ArrayType::$instances[$type] = new ArrayType($type);
        } else {
            return ArrayType::$instances[$type];
        }
    }
}
