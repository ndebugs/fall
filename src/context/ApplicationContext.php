<?php

namespace ndebugs\fall\context;

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\StaticTypeAdapter;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\reflection\XClass;
use ndebugs\fall\reflection\type\Type;
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
        
        $classPaths = array_keys($classLoader->getClassMap());
        $basePackages = $this->properties['scan_packages'];
        foreach ($classPaths as $classPath) {
            $this->scanPackages($basePackages, $classPath);
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
     * @param string $classPath
     * @return ComponentContext
     */
    private function scanPackage($basePackage, $classPath) {
        if (Strings::startsWith($classPath, $basePackage)) {
            $class = new XClass($classPath);
            $type = $class->getAnnotation($this, Component::class);
            if ($type) {
                return $this->componentContexts[$classPath] = new ComponentContext($class);
            }
        }
        return null;
    }
    
    /**
     * @param string[] $basePackages
     * @param string $classPath
     * @return ComponentContext
     */
    private function scanPackages($basePackages, $classPath) {
        foreach ($basePackages as $basePackage) {
            $context = $this->scanPackage($basePackage, $classPath);
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
     * @param string $classPath
     * @return object
     */
    public function getComponent($classPath) {
        if (isset($this->componentContexts[$classPath])) {
            $context = $this->componentContexts[$classPath];
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
        $context = new ComponentContext(new XClass($object), $object);
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
     * @param string $classPath
     * @param Type $type
     * @return object
     */
    public function getTypeAdapter($classPath, Type $type) {
        $currentType = null;
        $currentAdapter = null;
        foreach ($this->componentContexts as $context) {
            $contextType = $context->getType($this);
            $contextClass = $context->getClass();
            if (!$contextClass->isSubclassOf($classPath) || !$contextType instanceof TypeAdapter) {
                continue;
            }
            
            $matchType = $contextType->matches($type, $currentType);
            if ($matchType == $type) {
                return $context->getValue($this);
            } else if ($matchType) {
                $currentType = $matchType;
                $currentAdapter = $context->getValue($this);
            }
        }
        return $currentAdapter;
    }
    
    /**
     * @param string $classPath
     * @param string $type
     * @return object
     */
    public function getStaticTypeAdapter($classPath, $type) {
        foreach ($this->componentContexts as $context) {
            $contextType = $context->getType($this);
            $class = $context->getClass();
            if ($class->isSubclassOf($classPath) &&
                    $contextType instanceof StaticTypeAdapter &&
                    $contextType->matches($type)) {
                return $context->getValue($this);
            }
        }
        return null;
    }
}
