<?php

namespace ndebugs\fall\context;

use ReflectionClass;
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\DataTypeAdapter;
use ndebugs\fall\annotation\DocumentTypeAdapter;
use ndebugs\fall\util\Strings;

class ApplicationContext {
    
    private $properties = [
        'base_url' => '/',
        'scan_packages' => ['ndebugs\\fall'],
        'temp_directory' => './tmp'
    ];
    
    private $componentContexts;
    
    public function __construct(ClassLoader $classLoader, $properties) {
        $this->mergeProperties($properties);
        
        $this->componentContexts = [
            self::class => new ComponentContext(self::class, null, $this)
        ];
        
        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();
        
        $basePackages = $this->properties['scan_packages'];
        $classes = array_keys($classLoader->getClassMap());
        foreach ($classes as $class) {
            $this->scanPackages($reader, $basePackages, $class);
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
    
    private function scanPackage(AnnotationReader $reader, $basePackage, $class) {
        if (Strings::startsWith($class, $basePackage)) {
            $reflection = new ReflectionClass($class);
            $type = $reader->getClassAnnotation($reflection, Component::class);
            if ($type) {
                return $this->componentContexts[$class] = new ComponentContext($class, $type);
            }
        }
        return null;
    }
    
    private function scanPackages(AnnotationReader $reader, $basePackages, $class) {
        foreach ($basePackages as $basePackage) {
            $context = $this->scanPackage($reader, $basePackage, $class);
            if ($context) {
                return $context;
            }
        }
    }
    
    public function getProperty($key) {
        return isset($this->properties[$key]) ? $this->properties[$key] : null;
    }
    
    public function getComponent($class) {
        if (isset($this->componentContexts[$class])) {
            $context = $this->componentContexts[$class];
            return $context->getValue($this);
        } else {
            return null;
        }
    }
    
    public function getComponentMap($type = null) {
        $map = [];
        foreach ($this->componentContexts as $context) {
            if ($type === null || $context->getType() instanceof $type) {
                $map[$context->getClass()] = $context->getType();
            }
        }
        return $map;
    }
    
    public function getDataTypeAdapter($type) {
        foreach ($this->componentContexts as $context) {
            $componentType = $context->getType();
            if ($componentType instanceof DataTypeAdapter &&
                    $type === $componentType->type) {
                return $context->getValue($this);
            }
        }
        return null;
    }
    
    public function getDocumentTypeAdapter($type) {
        foreach ($this->componentContexts as $context) {
            $componentType = $context->getType();
            if ($componentType instanceof DocumentTypeAdapter &&
                    in_array($type, $componentType->types, true)) {
                return $context->getValue($this);
            }
        }
        return null;
    }
}
