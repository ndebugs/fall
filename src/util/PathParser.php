<?php

namespace ndebugs\fall\util;

class PathParser extends TokenizedParser {
    
    private $separator;
    
    public function __construct($separator, $value, $offset = 0) {
        parent::__construct($value, $offset);
        
        $this->separator = $separator;
    }
    
    protected function nextChar($previous, $current) {
        return $current != $this->separator ? $current : null;
    }
}
