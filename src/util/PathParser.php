<?php

namespace ndebugs\fall\util;

class PathParser extends TokenizedParser {
    
    /** @var string */
    private $separator;
    
    /**
     * @param string $separator
     * @param string $value
     * @param integer $offset [optional]
     */
    public function __construct($separator, $value, $offset = 0) {
        parent::__construct($value, $offset);
        
        $this->separator = $separator;
    }
    
    /**
     * @param string $previous
     * @param string $current
     * @return string
     */
    protected function nextChar($previous, $current) {
        return $current != $this->separator ? $current : null;
    }
}
