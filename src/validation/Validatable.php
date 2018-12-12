<?php

namespace ndebugs\fall\validation;

interface Validatable {
    
    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public function getMessage($name, $value);
    
    /**
     * @param string $value
     * @return boolean
     */
    public function validate($value);
}
