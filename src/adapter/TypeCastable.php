<?php

namespace ndebugs\fall\adapter;

use ndebugs\fall\reflection\type\Type;

interface TypeCastable {
    
    /**
     * @param mixed $value
     * @param Type $type [optional]
     * @return mixed
     */
    public function cast($value, Type $type = null);
    
    /**
     * @param mixed $value
     * @param Type $type [optional]
     * @return mixed
     */
    public function uncast($value, Type $type = null);
}
