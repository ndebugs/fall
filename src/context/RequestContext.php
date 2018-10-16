<?php

namespace ndebugs\fall\context;

use ndebugs\fall\adapter\DocumentTypeAdapter;
use ndebugs\fall\http\HTTPRequest;
use ndebugs\fall\io\FileInputStream;
use ndebugs\fall\routing\Route;

class RequestContext {
    
    /** @var Route */
    private $route;
    
    /** @var HTTPRequest */
    private $value;
    
    /** @var array */
    private $pathVariables;
    
    /** @var mixed */
    private $content;
    
    /**
     * @param Route $route
     * @param HTTPRequest $value
     * @param string[] $pathVariables
     */
    public function __construct(Route $route, HTTPRequest $value, array $pathVariables) {
        $this->route = $route;
        $this->value = $value;
        $this->pathVariables = $pathVariables;
    }
    
    /** @return Route */
    public function getRoute() {
        return $this->route;
    }

    /** @return HTTPRequest */
    public function getValue() {
        return $this->value;
    }

    /** @return string[] */
    public function getPathVariable($key) {
        return isset($this->pathVariables[$key]) ? $this->pathVariables[$key] : null;
    }

    /**
     * @param ApplicationContext $context
     * @return mixed
     */
    public function getContent(ApplicationContext $context) {
        if (!$this->content) {
            $this->content = $this->loadContent($context);
        }
        
        return $this->content;
    }
    
    /**
     * @param ApplicationContext $context
     * @return mixed
     */
    public function loadContent(ApplicationContext $context) {
        $in = $this->value->getContent();
        if ($in) {
            $content = '';
            while ($in->hasNext()) {
                $content .= $in->read(FileInputStream::DEFAULT_READ_BUFFER);
            }
            $in->reset();
            
            $contentType = $this->value->getContentType();
            if ($contentType) {
                $adapter = $context->getTypeAdapter(DocumentTypeAdapter::class, $contentType);
                return $adapter ? $adapter->parse($content) : $content;
            } else {
                return $content;
            }
        }
        return null;
    }
}
