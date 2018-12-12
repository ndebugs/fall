<?php

namespace ndebugs\fall\reflection\type;

class BooleanType extends Type {
    
    const NAME = 'boolean';
    
    /** @var BooleanType */
    private static $instance;
    
    public function __construct() {
        parent::__construct(BooleanType::NAME);
    }
    
    /** @return BooleanType */
    public static function getInstance() {
        if (!BooleanType::$instance) {
            BooleanType::$instance = new BooleanType();
        }
        
        return BooleanType::$instance;
    }
}
