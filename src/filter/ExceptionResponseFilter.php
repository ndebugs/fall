<?php

namespace ndebugs\fall\filter;

use Exception;
use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\http\HTTPException;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\web\HTTPInternalServerErrorException;
use ndebugs\fall\web\TemplateManager;

/** @TypeAdapter(Exception::class) */
class ExceptionResponseFilter implements ResponseFilterable {
    
    /**
     * @var TemplateManager
     * @Autowired
     */
    public $templateManager;
    
    /**
     * @param HTTPResponse $response
     * @param mixed $value
     * @return void
     */
    public function filter(HTTPResponse $response, $value) {
        $error = !$value instanceof HTTPException ?
                new HTTPInternalServerErrorException($value->getMessage(), $value) : $value;
        
        $response->setStatusCode($error->getCode());
        $this->templateManager->renderError($error, $response->getContent());
    }
}
