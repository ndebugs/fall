<?php

namespace ndebugs\fall\util;

abstract class TokenizedParser {
    
    /** @var string */
    private $value;
    
    /** @var integer */
    private $index;
    
    /** @var integer */
    private $offset;
    
    /** @var integer */
    private $length;
    
    /**
     * @param string $value
     * @param integer $offset [optional]
     */
    public function __construct($value, $offset = 0) {
        $this->value = $value;
        $this->offset = $offset;
        $this->length = strlen($value);
        
        $this->reset();
    }
    
    /** @return string */
    public function getValue() {
        return $this->value;
    }

    /** @return integer */
    public function getIndex() {
        return $this->index;
    }

    /** @return integer */
    public function getOffset() {
        return $this->offset;
    }

    /** @return integer */
    public function getLength() {
        return $this->length;
    }

    /** @return void */
    public function reset() {
        $this->index = $this->offset - 1;
    }
    
    /** @return boolean */
    public function hasNext() {
        return $this->index < $this->length;
    }
    
    /**
     * @param string $previous
     * @param string $current
     * @return string
     */
    protected abstract function nextChar($previous, $current);
    
    /** @return string */
    public function next() {
        if ($this->hasNext()) {
            $i = $this->index + 1;
            $result = '';
            $prev = null;
            for (; $i < $this->length; $i++) {
                $curr = $this->value[$i];
                $c = $this->nextChar($prev, $curr);
                $prev = $curr;
                if ($c != null) {
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
