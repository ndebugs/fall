<?php

namespace ndebugs\fall\context;

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\annotation\TypeFilter;
use ndebugs\fall\reflection\MetaClass;
use ndebugs\fall\util\Strings;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\ContextFactory;

class ApplicationContext {
    
    private $properties = [
        'base_url' => '/',
        'scan_packages' => ['ndebugs\\fall'],
        'temp_directory' => './tmp',
        'web_directory' => './web'
    ];
    
    private $componentContexts = [];
    
    public function __construct(ClassLoader $classLoader, $properties) {
        $this->mergeProperties($properties);
        
        AnnotationRegistry::registerLoader('class_exists');
        
        $this->setComponent($this);
        $this->setComponent(new AnnotationReader());
        $this->setComponent(DocBlockFactory::createInstance());
        $this->setComponent(new ContextFactory());
        
        $classes = array_keys($classLoader->getClassMap());
        $basePackages = $this->properties['scan_packages'];
        foreach ($classes as $class) {
            $this->scanPackages($basePackages, $class);
        }
    }
    
    private function mergeProperties($properties) {
        foreach ($properties as $key => $value) {
            if (is_array($value) && isset($this->properties[$key]) &&
                    is_array($this->properties[$key])) {
                $this->properties[$key] = array_merge($this->properties[$key], $value);
            } else {
                $this->properties[$key] = $value;
            }
        }
    }
    
    private function scanPackage($basePackage, $class) {
        if (Strings::startsWith($class, $basePackage)) {
            $reflection = new MetaClass($class);
            $type = $reflection->getAnnotation($this, Component::class);
            if ($type) {
                return $this->componentContexts[$class] = new ComponentContext($this, $reflection);
            }
        }
        return null;
    }
    
    private function scanPackages($basePackages, $class) {
        foreach ($basePackages as $basePackage) {
            $context = $this->scanPackage($basePackage, $class);
            if ($context) {
                return $context;
            }
        }
    }
    
    public function getProperty($key) {
        return isset($this->properties[$key]) ? $this->properties[$key] : null;
    }
    
    public function getAnnotationReader() {
        return $this->annotationReader;
    }

    public function getComponent($class) {
        if (isset($this->componentContexts[$class])) {
            $context = $this->componentContexts[$class];
            return $context->getValue($this);
        } else {
            return null;
        }
    }
    
    public function setComponent($object) {
        $context = new ComponentContext($this, new MetaClass($object), $object);
        $this->componentContexts[get_class($object)] = $context;
    }
    
    public function getComponentContexts($type = null) {
        $contexts = [];
        foreach ($this->componentContexts as $context) {
            $contextType = $context->getType();
            if ($type === null || $contextType instanceof $type) {
                $contexts[] = $context;
            }
        }
        return $contexts;
    }
    
    public function getTypeAdapter($class, $type) {
        foreach ($this->componentContexts as $context) {
            $contextType = $context->getType();
            if ($contextType instanceof TypeAdapter &&
                    $contextType instanceof $class &&
                    $contextType->hasType($type)) {
                return $context->getValue($this);
            }
        }
        return null;
    }
    
    public function getTypeFilter($class, $object) {
        foreach ($this->componentContexts as $context) {
            $contextType = $context->getType();
            if ($contextType instanceof TypeFilter &&
                    $contextType instanceof $class &&
                    $contextType->matchType($object)) {
                return $context->getValue($this);
            }
        }
        return null;
    }
}
