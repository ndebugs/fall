<?php

namespace ndebugs\fall\reflection\type;

class AnyType extends Type {
    
    const NAME = 'mixed';
    
    /** @var AnyType */
    private static $instance;
    
    public function __construct() {
        parent::__construct(AnyType::NAME);
    }
    
    /** @return AnyType */
    public static function getInstance() {
        if (!AnyType::$instance) {
            AnyType::$instance = new AnyType();
        }
        
        return AnyType::$instance;
    }
}
