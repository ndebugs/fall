<?php

namespace ndebugs\fall\reflection;

use ReflectionProperty;
use Doctrine\Common\Annotations\AnnotationReader;
use ndebugs\fall\context\ApplicationContext;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\ContextFactory;

class MetaProperty extends ReflectionProperty {
    
    private $docBlock;
    private $type;
    private $annotations;
    
    public function getDocBlock(ApplicationContext $context) {
        if (!$this->docBlock) {
            $factory = $context->getComponent(DocBlockFactory::class);
            $docComment = $this->getDocComment();
            
            $contextFactory = $context->getComponent(ContextFactory::class);
            $context = $contextFactory->createFromReflector($this);
                
            $this->docBlock = $factory->create($docComment, $context);
        }
        
        return $this->docBlock;
    }
    
    public function getType(ApplicationContext $context) {
        if (!$this->type) {
            $docblock = $this->getDocBlock($context);
            $tags = $docblock->getTagsByName('var');
            if ($tags) {
                $type = (string) $tags[0]->getType();
                $this->type = $type[0] === '\\' ? substr($type, 1) : $type;
            } else {
                $this->type = 'mixed';
            }
        }
        
        return $this->type;
    }

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
            $this->annotations = $reader->getPropertyAnnotations($this);
        }
        
        return $this->annotations;
    }
}