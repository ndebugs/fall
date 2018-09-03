<?php

namespace ndebugs\fall\util;

abstract class TokenizedParser {
    
    private $value;
    private $index;
    private $offset;
    private $length;
    
    public function __construct($value, $offset = 0) {
        $this->value = $value;
        $this->offset = $offset;
        $this->length = strlen($value);
        
        $this->reset();
    }
    
    public function getValue() {
        return $this->value;
    }

    public function getIndex() {
        return $this->index;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function getLength() {
        return $this->length;
    }

    public function reset() {
        $this->index = $this->offset - 1;
    }
    
    public function hasNext() {
        return $this->index < $this->length;
    }
    
    protected abstract function nextChar($previous, $current);
    
    public function next() {
        if ($this->hasNext()) {
            $i = $this->index + 1;
            $result = '';
            $prev = null;
            for (; $i < $this->length; $i++) {
                $curr = $this->value[$i];
                $c = $this->nextChar($prev, $curr);
                $prev = $curr;
                if ($c) {
                    $result .= $c;
                } else {
                    break;
                }
            }
            $this->nextChar($prev, null);
            $this->index = $i;
            
            return $result;
        } else {
            return null;
        }
    }
}
