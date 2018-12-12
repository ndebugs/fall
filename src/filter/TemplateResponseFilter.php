<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\web\Template;
use ndebugs\fall\web\TemplateManager;

/** @TypeAdapter(Template::class) */
class TemplateResponseFilter implements ResponseFilterable {
    
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
        $this->templateManager->render($value, $response->getContent());
    }
}
