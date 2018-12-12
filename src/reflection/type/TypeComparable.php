<?php

namespace ndebugs\fall\reflection\type;

interface TypeComparable {
    
    const LESS_THAN = -1;
    const NOT_EQUAL = 0;
    const EQUAL = 1;
    const GREATER_THAN = 2;
    
    /**
     * @param Type $type
     * @return integer
     */
    public function compare(Type $type);
}
