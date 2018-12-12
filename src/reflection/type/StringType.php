<?php

namespace ndebugs\fall\reflection\type;

class StringType extends Type {
    
    const NAME = 'string';
    
    /** @var StringType */
    private static $instance;
    
    public function __construct() {
        parent::__construct(StringType::NAME);
    }
    
    /** @return StringType */
    public static function getInstance() {
        if (!StringType::$instance) {
            StringType::$instance = new StringType();
        }
        
        return StringType::$instance;
    }
}
