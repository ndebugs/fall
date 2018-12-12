<?php

namespace ndebugs\fall\reflection\type;

class NullType extends Type {
    
    const NAME = 'NULL';
    
    /** @var NullType */
    private static $instance;
    
    public function __construct() {
        parent::__construct(NullType::NAME);
    }
    
    /** @return NullType */
    public static function getInstance() {
        if (!NullType::$instance) {
            NullType::$instance = new NullType();
        }
        
        return NullType::$instance;
    }
}
