<?php

namespace ndebugs\fall\reflection;

use ReflectionClass;
use Doctrine\Common\Annotations\AnnotationReader;
use ndebugs\fall\context\ApplicationContext;

class MetaClass extends ReflectionClass {
    
    private $annotations;
    
    public function getAnnotation(ApplicationContext $context, $class) {
        $annotations = $this->getAnnotations($context);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof $class) {
                return $annotation;
            }
        }
        
        return null;
    }

    public function getAnnotations(ApplicationContext $context) {
        if ($this->annotations === null) {
            $reader = $context->getComponent(AnnotationReader::class);
            $this->annotations = $reader->getClassAnnotations($this);
        }
        
        return $this->annotations;
    }
    
    public function getProperties($filter = null) {
        return $filter !== null ? parent::getProperties($filter) : parent::getProperties();
    }
    
    public function getMetaProperty($name) {
        $reflection = $this->getProperty($name);
        return new MetaProperty($this->getName(), $reflection->getName());
    }

    public function getMetaProperties($filter = null) {
        $properties = [];
        $reflections = $filter !== null ?
                $this->getProperties($filter) : $this->getProperties();
        foreach ($reflections as $reflection) {
            $properties[] = new MetaProperty($this->getName(), $reflection->getName());
        }
        
        return $properties;
    }

    public function getMethods($filter = null) {
        return $filter !== null ? parent::getMethods($filter) : parent::getMethods();
    }
    
    public function getMetaMethod($name) {
        $reflection = $this->getMethod($name);
        return new MetaMethod($this->getName(), $reflection->getName());
    }

    public function getMetaMethods($filter = null) {
        $methods = [];
        $reflections = $this->getMethods($filter);
        foreach ($reflections as $reflection) {
            $methods[] = new MetaMethod($this->getName(), $reflection->getName());
        }
        
        return $methods;
    }
}
