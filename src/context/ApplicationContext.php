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
    
    /** @var array */
    private $properties = [
        'base_url' => '/',
        'scan_packages' => ['ndebugs\\fall'],
        'temp_directory' => './tmp',
        'web_directory' => './web'
    ];
    
    /** @var ComponentContext[] */
    private $componentContexts = [];
    
    /**
     * @param ClassLoader $classLoader
     * @param array $properties
     */
    public function __construct(ClassLoader $classLoader, array $properties) {
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
    
    /**
     * @param array $properties
     * @return void
     */
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
    
    /**
     * @param string $basePackage
     * @param string $class
     * @return ComponentContext
     */
    private function scanPackage($basePackage, $class) {
        if (Strings::startsWith($class, $basePackage)) {
            $reflection = new MetaClass($class);
            $type = $reflection->getAnnotation($this, Component::class);
            if ($type) {
                return $this->componentContexts[$class] = new ComponentContext($reflection);
            }
        }
        return null;
    }
    
    /**
     * @param string[] $basePackages
     * @param string $class
     * @return ComponentContext
     */
    private function scanPackages($basePackages, $class) {
        foreach ($basePackages as $basePackage) {
            $context = $this->scanPackage($basePackage, $class);
            if ($context) {
                return $context;
            }
        }
    }
    
    /**
     * @param string $key
     * @return mixed
     */
    public function getProperty($key) {
        return isset($this->properties[$key]) ? $this->properties[$key] : null;
    }
    
    /**
     * @param string $class
     * @return object
     */
    public function getComponent($class) {
        if (isset($this->componentContexts[$class])) {
            $context = $this->componentContexts[$class];
            return $context->getValue($this);
        } else {
            return null;
        }
    }
    
    /**
     * @param object $object
     * @return void
     */
    public function setComponent($object) {
        $context = new ComponentContext(new MetaClass($object), $object);
        $this->componentContexts[get_class($object)] = $context;
    }
    
    /**
     * @param string $type [optional]
     * @return ComponentContext[]
     */
    public function getComponentContexts($type = null) {
        $contexts = [];
        foreach ($this->componentContexts as $context) {
            $contextType = $context->getType($this);
            if ($type === null || $contextType instanceof $type) {
                $contexts[] = $context;
            }
        }
        return $contexts;
    }
    
    /**
     * @param string $class
     * @param string $type
     * @param string $defaultType [optional]
     * @return object
     */
    public function getTypeAdapter($class, $type, $defaultType = null) {
        $defaultAdapter = null;
        foreach ($this->componentContexts as $context) {
            $contextType = $context->getType($this);
            $metadata = $context->getMetadata();
            if ($metadata->isSubclassOf($class) && $contextType instanceof TypeAdapter) {
                if ($contextType->hasType($type)) {
                    return $context->getValue($this);
                } else if ($defaultType && $contextType->hasType($defaultType)) {
                    $defaultAdapter = $context->getValue($this);
                }
            }
        }
        return $defaultAdapter;
    }
    
    /**
     * @param string $class
     * @param object $object
     * @return object
     */
    public function getTypeFilter($class, $object) {
        foreach ($this->componentContexts as $context) {
            $contextType = $context->getType($this);
            $metadata = $context->getMetadata();
            if ($metadata->isSubclassOf($class) &&
                    $contextType instanceof TypeFilter &&
                    $contextType->matchType($object)) {
                return $context->getValue($this);
            }
        }
        return null;
    }
}
