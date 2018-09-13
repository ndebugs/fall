<?php

namespace ndebugs\fall\io;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\io\File;

/** @Component */
class FileManager {
    
    /** @Autowired(ApplicationContext::class) */
    public $context;
    
    private $tempDir;
    private $tempFiles = [];
    
    /** @PostConstruct */
    public function init() {
        $this->tempDir = new File($this->context->getProperty('temp_directory'));
        $this->tempDir->mkdir(true);
    }
    
    public function createTempFile($prefix) {
        $path = tempnam($this->tempDir, $prefix);
        if ($path !== false) {
            $file = new File($path);
            $this->tempFiles[] = $file;
            
            return $file;
        } else {
            return null;
        }
    }
    
    public function __destruct() {
        foreach ($this->tempFiles as $tempFile) {
            $tempFile->delete();
        }
    }
}
