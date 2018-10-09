<?php

namespace ndebugs\fall\util;

use ndebugs\fall\net\QueryString;

class QueryStringParser extends TokenizedParser {
    
    const STATE_KEY = 1;
    const STATE_VALUE = 2;
    
    /** @var integer */
    private $state = 0;
    
    /** @var integer */
    private $nextState = 0;
    
    function getState() {
        return $this->state;
    }

    /**
     * @param string $previous
     * @param string $current
     * @return string
     */
    protected function nextChar($previous, $current) {
        if ($this->nextState !== QueryStringParser::STATE_VALUE &&
                $current === QueryString::VALUE_DELIMITER) {
            $this->nextState = QueryStringParser::STATE_VALUE;
        } else if ($current === QueryString::PAIR_DELIMITER) {
            $this->nextState = QueryStringParser::STATE_KEY;
        } else {
            return $current;
        }
        
        return null;
    }
    
    /** @return string */
    public function next() {
        $state = $this->nextState ?
                    $this->nextState : QueryStringParser::STATE_KEY;
        $result = parent::next();
        
        $this->state = $result !== null ? $state : 0;
        
        return $result;
    }
}
