<?php

namespace ndebugs\fall\web;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPException;
use ndebugs\fall\io\File;
use ndebugs\fall\io\OutputStream;

/** @Component */
class TemplateManager {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @var TemplateFunction
     * @Autowired
     */
    public $templateFunction;
    
    /**
     * @param string $path
     * @return File
     */
    private function getFile($path) {
        $basePath = $this->context->getProperty('web_directory');
        $file = new File($basePath . DIRECTORY_SEPARATOR . $path);
        if ($file->isFile()) {
            return $file;
        } else if ($file->isDirectory()) {
            $defaultFile = new File($file . DIRECTORY_SEPARATOR . 'index.php');
            if ($defaultFile->isExists()) {
                return $defaultFile;
            }
        }
        
        return null;
    }
    
    /**
     * @param HTTPException $error
     * @return File
     */
    private function getErrorFile(HTTPException $error) {
        $basePath = $this->context->getProperty('web_directory');
        $errorDir = new File($basePath . DIRECTORY_SEPARATOR . 'error');
        if ($errorDir->isExists()) {
            $file = new File($errorDir . DIRECTORY_SEPARATOR . $error->getCode() . '.php');
            if ($file->isExists()) {
                return $file;
            }

            $defaultFile = new File($errorDir . DIRECTORY_SEPARATOR . 'index.php');
            if ($defaultFile->isExists()) {
                return $defaultFile;
            }
        }
        return null;
    }
    
    /**
     * @param File $file
     * @param OutputStream $out
     * @param array $parameters [optional]
     * @return void
     */
    private function renderFile(File $file, OutputStream $out, array $parameters = null) {
        if ($parameters === null) {
            $parameters = [];
        }
        $parameters['f'] = $this->templateFunction;
        
        extract($parameters);
        
        ob_start();
        include($file);
        
        $content = ob_get_contents();
        ob_end_clean();
        
        $out->write($content);
    }
    
    /**
     * @param Template $template
     * @param OutputStream $out
     * @return void
     */
    public function render(Template $template, OutputStream $out) {
        $file = $this->getFile($template->getName());
        $parameters = $template->getParameters();
        
        $this->renderFile($file, $out, $parameters);
    }
    
    /**
     * @param HTTPException $error
     * @param OutputStream $out
     * @return void
     */
    public function renderError(HTTPException $error, OutputStream $out) {
        $file = $this->getErrorFile($error);
        if ($file) {
            $this->renderFile($file, $out, ['error' => $error]);
        } else {
            $code = $error->getCode();
            $description = $error->getDescription();
            
            $out->write(
                    '<html>' .
                    '   <head>' .
                    '       <title>' . $code . ' ' . $description .'</title>' .
                    '   </head>' .
                    '   <body>' .
                    '       <h1>' . $description . '</h1>' .
                    '       <p>' . $error->getMessage() . '</p>' .
                    '   </body>' .
                    '</html>');
        }
    }
}
