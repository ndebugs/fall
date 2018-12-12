<?php

namespace ndebugs\fall\reflection;

use ReflectionClass;
use Doctrine\Common\Annotations\AnnotationReader;
use ndebugs\fall\context\ApplicationContext;

class XClass extends ReflectionClass {
    
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
	 * @param string $class [optional]
	 * @return object[]
	 */
    public function getAnnotations(ApplicationContext $context, $class = null) {
        if ($this->annotations === null) {
            $reader = $context->getComponent(AnnotationReader::class);
            $this->annotations = $reader->getClassAnnotations($this);
        }
        
        if ($class !== null) {
            $annotations = [];
            foreach ($this->annotations as $annotation) {
                if ($annotation instanceof $class) {
                    $annotations[] = $annotation;
                }
            }
            
            return $annotations;
        } else {
            return $this->annotations;
        }
    }
    
	/**
	 * @param string $name
	 * @return XProperty
	 */
    public function getProperty($name) {
        $reflection = parent::getProperty($name);
        return new XProperty($this->getName(), $reflection->getName());
    }

	/**
	 * @param integer $filter [optional]
	 * @return XProperty[]
	 */
    public function getProperties($filter = null) {
        $properties = [];
        $reflections = $filter !== null ?
                parent::getProperties($filter) : parent::getProperties();
        foreach ($reflections as $reflection) {
            $properties[] = new XProperty($this->getName(), $reflection->getName());
        }
        
        return $properties;
    }

	/**
	 * @param string $name
	 * @return XMethod
	 */
    public function getMethod($name) {
        $reflection = parent::getMethod($name);
        return new XMethod($this->getName(), $reflection->getName());
    }

	/**
	 * @param integer $filter [optional]
	 * @return XMethod[]
	 */
    public function getMethods($filter = null) {
        $methods = [];
        $reflections = $filter !== null ?
                parent::getMethods($filter) : parent::getMethods();
        foreach ($reflections as $reflection) {
            $methods[] = new XMethod($this->getName(), $reflection->getName());
        }
        
        return $methods;
    }
}
