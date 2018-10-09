<?php

namespace ndebugs\fall\reflection;

use ReflectionMethod;
use Doctrine\Common\Annotations\AnnotationReader;
use ndebugs\fall\context\ApplicationContext;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\ContextFactory;

class MetaMethod extends ReflectionMethod {
    
    /** @var DocBlock */
    private $docBlock;
    
    /** @var string */
    private $type;
    
    /** @var object[] */
    private $annotations;
    
	/**
	 * @param ApplicationContext $context
	 * @return DocBlock
	 */
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
    
	/**
	 * @param ApplicationContext $context
	 * @return string
	 */
    public function getType(ApplicationContext $context) {
        if (!$this->type) {
            $docblock = $this->getDocBlock($context);
            $tags = $docblock->getTagsByName('return');
            if ($tags) {
                $type = (string) $tags[0]->getType();
                $this->type = $type[0] === '\\' ? substr($type, 1) : $type;
            } else {
                $this->type = 'mixed';
            }
        }
        
        return $this->type;
    }

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
            $this->annotations = $reader->getMethodAnnotations($this);
        }
        
        return $this->annotations;
    }
}
