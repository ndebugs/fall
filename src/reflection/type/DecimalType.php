<?php

namespace ndebugs\fall\reflection\type;

class DecimalType extends Type {
    
    const NAME = 'double';
    
    /** @var DecimalType */
    private static $instance;
    
    public function __construct() {
        parent::__construct(DecimalType::NAME);
    }
    
    /** @return DecimalType */
    public static function getInstance() {
        if (!DecimalType::$instance) {
            DecimalType::$instance = new DecimalType();
        }
        
        return DecimalType::$instance;
    }
}
