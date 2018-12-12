<?php

namespace ndebugs\fall\reflection;

use ReflectionMethod;
use Doctrine\Common\Annotations\AnnotationReader;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\reflection\TypeResolver;
use ndebugs\fall\reflection\type\Type;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\ContextFactory;

class XMethod extends ReflectionMethod {
    
    /** @var DocBlock */
    private $docBlock;
    
    /** @var Type */
    private $type;
    
    /** @var object[] */
    private $annotations;
    
	/**
	 * @param ApplicationContext $context
	 * @return DocBlock
	 */
    public function getDocBlock(ApplicationContext $context) {
        $docComment = $this->getDocComment();
        if (!$this->docBlock && $docComment) {
            $factory = $context->getComponent(DocBlockFactory::class);
            $contextFactory = $context->getComponent(ContextFactory::class);
            $context = $contextFactory->createFromReflector($this);
                
            $this->docBlock = $factory->create($docComment, $context);
        }
        
        return $this->docBlock;
    }
    
	/**
	 * @param ApplicationContext $context
	 * @return Type
	 */
    public function getType(ApplicationContext $context) {
        if ($this->type === null) {
            $docblock = $this->getDocBlock($context);
            $tags = $docblock ? $docblock->getTagsByName('return') : null;
            $this->type = TypeResolver::fromType($tags ? $tags[0]->getType() : null);
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
	 * @param string $class [optional]
	 * @return object[]
	 */
    public function getAnnotations(ApplicationContext $context, $class = null) {
        if ($this->annotations === null) {
            $reader = $context->getComponent(AnnotationReader::class);
            $this->annotations = $reader->getMethodAnnotations($this);
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
}
