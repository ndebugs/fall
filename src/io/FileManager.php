<?php

namespace ndebugs\fall\io;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\io\File;

/** @Component */
class FileManager {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /** @var File */
    private $tempDir;
    
    /** @var File[] */
    private $tempFiles = [];
    
    /**
     * @return void
     * @PostConstruct
     */
    public function init() {
        $this->tempDir = new File($this->context->getProperty('temp_directory'));
        $this->tempDir->mkdir(true);
    }
    
    /**
     * @param string $prefix
     * @return File
     */
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
    
    /** @return void */
    public function __destruct() {
        foreach ($this->tempFiles as $tempFile) {
            $tempFile->delete();
        }
    }
}
