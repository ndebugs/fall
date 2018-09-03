<?php

namespace ndebugs\fall\context;

use ndebugs\fall\net\HTTPRequest;
use ndebugs\fall\io\FileInputStream;
use ndebugs\fall\routing\Route;

class RequestContext {
    
    private $route;
    private $value;
    private $pathVariables;
    private $data;
    
    public function __construct(Route $route, HTTPRequest $value, array $pathVariables) {
        $this->route = $route;
        $this->value = $value;
        $this->pathVariables = $pathVariables;
    }
    
    public function getRoute() {
        return $this->route;
    }

    public function getValue() {
        return $this->value;
    }

    public function getPathVariable($key) {
        return isset($this->pathVariables[$key]) ? $this->pathVariables[$key] : null;
    }

    public function getContent(ApplicationContext $context) {
        if (!$this->data) {
            $this->data = $this->loadContent($context);
        }
        
        return $this->data;
    }
    
    public function loadContent(ApplicationContext $context) {
        $contentType = $this->value->getHeader('Content-Type');
        $adapter = $contentType ? $context->getDocumentTypeAdapter($contentType) : null;
        
        $in = $this->value->getBody();
        if ($in) {
            $content = '';
            while ($in->hasNext()) {
                $content .= $in->read(FileInputStream::DEFAULT_READ_BUFFER);
            }
            $in->reset();
            
            return $adapter ? $adapter->unmarshall($content) : $content;
        }
        return null;
    }
}
