<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\ResponseFilter;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\web\Template;
use ndebugs\fall\web\TemplateManager;

/** @ResponseFilter(Template::class) */
class TemplateResponseFilter implements ResponseFilterable {
    
    /** @Autowired(TemplateManager::class) */
    public $templateManager;
    
    public function filter(HTTPResponse $response, $value) {
        $this->templateManager->render($value, $response->getContent());
    }
}
