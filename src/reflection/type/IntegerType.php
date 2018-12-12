<?php

namespace ndebugs\fall\reflection\type;

class IntegerType extends Type {
    
    const NAME = 'integer';
    
    /** @var IntegerType */
    private static $instance;
    
    public function __construct() {
        parent::__construct(IntegerType::NAME);
    }
    
    /** @return IntegerType */
    public static function getInstance() {
        if (!IntegerType::$instance) {
            IntegerType::$instance = new IntegerType();
        }
        
        return IntegerType::$instance;
    }
}
