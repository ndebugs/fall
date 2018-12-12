<?php

namespace ndebugs\fall\reflection\type;

abstract class Type implements TypeComparable {
    
    /** @var string */
    private $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    /**
     * @param Type $type
     * @return integer
     */
    public function compare(Type $type) {
        return $this == $type ? TypeComparable::EQUAL : TypeComparable::NOT_EQUAL;
    }
    
    public function __toString() {
        return $this->name;
    }
}
