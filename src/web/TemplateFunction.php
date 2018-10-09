<?php

namespace ndebugs\fall\web;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\util\Strings;

/** @Component */
class TemplateFunction {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @param string $path
     * @return string
     */
    public function url($path) {
        $baseURL = $this->context->getProperty('base_url');
        return !Strings::startsWith($path, $baseURL) ? $baseURL . $path : $path;
    }
    
    /**
     * @param string $path
     * @return void
     */
    public function js($path) {
        echo '<script type="text/javascript" src="' . $this->url($path) . '"></script>';
    }
    
    /**
     * @param string $path
     * @return void
     */
    public function css($path) {
        echo '<link rel="stylesheet" href="' . $this->url($path) . '">';
    }
}
