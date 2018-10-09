<?php

namespace ndebugs\fall\reflection;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Doctrine\Common\Annotations\AnnotationReader;
use ndebugs\fall\context\ApplicationContext;

class MetaClass extends ReflectionClass {
    
    /** @var object[] */
    private $annotations;
    
	/**
	 * @param ApplicationContext $context
	 * @param string $class
	 * @return object
	 */
    public function getAnnotation(ApplicationContext $context, $class) {
        $annotations = $this->getAnnotations($context);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof $class) {
                return $annotation;
            }
        }
        
        return null;
    }

	/**
	 * @param ApplicationContext $context
	 * @return object[]
	 */
    public function getAnnotations(ApplicationContext $context) {
        if ($this->annotations === null) {
            $reader = $context->getComponent(AnnotationReader::class);
            $this->annotations = $reader->getClassAnnotations($this);
        }
        
        return $this->annotations;
    }
    
	/**
	 * @param integer $filter [optional]
	 * @return ReflectionProperty[]
	 */
    public function getProperties($filter = null) {
        return $filter !== null ? parent::getProperties($filter) : parent::getProperties();
    }
    
	/**
	 * @param string $name
	 * @return MetaProperty
	 */
    public function getMetaProperty($name) {
        $reflection = $this->getProperty($name);
        return new MetaProperty($this->getName(), $reflection->getName());
    }

	/**
	 * @param integer $filter [optional]
	 * @return MetaProperty[]
	 */
    public function getMetaProperties($filter = null) {
        $properties = [];
        $reflections = $filter !== null ?
                $this->getProperties($filter) : $this->getProperties();
        foreach ($reflections as $reflection) {
            $properties[] = new MetaProperty($this->getName(), $reflection->getName());
        }
        
        return $properties;
    }

	/**
	 * @param integer $filter [optional]
	 * @return ReflectionMethod[]
	 */
    public function getMethods($filter = null) {
        return $filter !== null ? parent::getMethods($filter) : parent::getMethods();
    }
    
	/**
	 * @param string $name
	 * @return MetaMethod
	 */
    public function getMetaMethod($name) {
        $reflection = $this->getMethod($name);
        return new MetaMethod($this->getName(), $reflection->getName());
    }

	/**
	 * @param integer $filter [optional]
	 * @return MetaMethod[]
	 */
    public function getMetaMethods($filter = null) {
        $methods = [];
        $reflections = $this->getMethods($filter);
        foreach ($reflections as $reflection) {
            $methods[] = new MetaMethod($this->getName(), $reflection->getName());
        }
        
        return $methods;
    }
}
