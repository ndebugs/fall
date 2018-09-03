<?php

namespace ndebugs\fall\net;

use ndebugs\fall\util\QueryStringParser;

class QueryString {
    
    const VALUE_DELIMITER = '=';
    const PAIR_DELIMITER = '&';
    
    private $values;
    
    public function __construct(array $values = []) {
        $this->values = $values;
    }

    public function get($key) {
        return isset($this->values[$key]) ? $this->values[$key] : null;
    }
    
    public function set($key, $value) {
        if (isset($this->values[$key])) {
            $currentValue = &$this->values[$key];
            if (is_array($currentValue)) {
                if (!in_array($value, $currentValue, true)) {
                    $currentValue[] = $value;
                }
            } else if ($currentValue !== $value) {
                $values = [$currentValue, $value];
                $this->values[$key] = $values;
            }
        } else {
            $this->values[$key] = $value;
        }
    }

    public function getValues() {
        return $this->values;
    }
    
    private function toPairString($key, $value) {
        return $value !== null ?
            $key . QueryString::VALUE_DELIMITER . $value : $key;
    }

    private function toStrings($key, array $values) {
        $result = '';
        foreach ($values as $value) {
            if ($result) {
                $result .= QueryString::PAIR_DELIMITER;
            }
            $result .= $this->toPairString($key, $value);
        }
        return $result;
    }
    
    public function __toString() {
        $result = '';
        foreach ($this->values as $key => $value) {
            if ($result) {
                $result .= QueryString::PAIR_DELIMITER;
            }
            
            $result .= is_array($value) ?
                $this->toStrings($key, $value) :
                $this->toPairString($key, $value);
        }
        return $result;
    }
    
    public static function parse($value, $offset = 0) {
        $parser = new QueryStringParser($value, $offset);
        $result = new QueryString();
        $currentKey = null;
        while ($currentKey !== null || $parser->hasNext()) {
            $key = $currentKey === null ? $parser->next() : $currentKey;
            $value = $parser->hasNext() ? $parser->next() : null;
            
            if ($parser->getState() === QueryStringParser::STATE_VALUE) {
                $result->set($key, $value);
                $currentKey = null;
            } else if ($key !== null) {
                $result->set($key, null);
                $currentKey = $value;
            } else {
                $currentKey = $value;
            }
        }
        
        return $result;
    }
}
