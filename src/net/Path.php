<?php

namespace ndebugs\fall\net;

use ndebugs\fall\util\PathParser;

class Path {
    
    const SEPARATOR = '/';
    
    private $segments;
    private $separator;
    
    public function __construct(array $segments, $separator = Path::SEPARATOR) {
        $this->segments = $segments;
        $this->separator = $separator;
    }
    
    public function isAbsolute() {
        return $this->size() > 1 ? $this->segments[0]->isEmpty() : false;
    }

    public function isDirectory() {
        $size = $this->size();
        return $size > 1 ? $this->segments[$size - 1]->isEmpty() : false;
    }

    public function isEmpty() {
        return $this->size() === 1 ? $this->segments[0]->isEmpty() : false;
    }

    public function getSeparator() {
        return $this->separator;
    }

    public function get($index) {
        return isset($this->segments[$index]) ? $this->segments[$index] : null;
    }
    
    public function size() {
        return count($this->segments);
    }
    
    public function matches(Path $path, $pathOffset = 0, $offset = 0, $length = -1) {
        $index = $offset;
        $pathIndex = $pathOffset;
        $size = $length === -1 ?
            max($this->size(), $path->size() - $pathIndex + $index) :
            $offset + $length;
        $params = [];
        for (;$index < $size; $index++, $pathIndex++) {
            $segment = $this->get($index);
            $pathSegment = $path->get($pathIndex);
            if (!$segment || !$pathSegment) {
                return null;
            } else if ($segment->isVariable()) {
                $params[$segment->getName()] = $pathSegment->getName();
            } else if ($segment->getName() !== $pathSegment->getName()) {
                return null;
            }
        }
        
        return $index === $size ? $params : null;
    }
    
    public function __toString() {
        return join($this->separator, $this->segments);
    }
    
    public static function parse($separator, $value, $offset = 0) {
        $parser = new PathParser($separator, $value, $offset);
        
        $segments = [];
        while ($parser->hasNext()) {
            $name = $parser->next();
            $segments[] = PathSegment::parse($name);
        }
        
        return new Path($segments, $separator);
    }
    
    public static function parseURL($value, $offset = 0) {
        return Path::parse(Path::SEPARATOR, $value, $offset);
    }
}
