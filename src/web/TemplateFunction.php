<?php

namespace ndebugs\fall\web;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\util\Strings;

/** @Component */
class TemplateFunction {
    
    /** @Autowired(ApplicationContext::class) */
    public $context;
    
    public function url($path) {
        $baseURL = $this->context->getProperty('base_url');
        return !Strings::startsWith($path, $baseURL) ? $baseURL . $path : $path;
    }
    
    public function js($path) {
        echo '<script type="text/javascript" src="' . $this->url($path) . '"></script>';
    }
    
    public function css($path) {
        echo '<link rel="stylesheet" href="' . $this->url($path) . '">';
    }
}
