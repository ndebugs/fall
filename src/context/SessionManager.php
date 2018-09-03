<?php

namespace ndebugs\fall\context;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\net\HTTPRequestBuilder;
use ndebugs\fall\io\File;
use ndebugs\fall\io\FileInputStream;
use ndebugs\fall\io\FileOutputStream;

/** @Component */
class SessionManager {
    
    /** @Autowired(ApplicationContext::class) */
    public $context;
    
    private $session;
    private $request;
    private $tempFiles = [];
    
    /** @PostConstruct */
    public function init() {
        $file = new File($this->context->getProperty('temp_directory'));
        $file->mkdir(true);
    }
    
    public function getSession() {
        if (!$this->session) {
            $this->session = $this->createSession();
        }
        
        return $this->session;
    }
    
    public function getRequest() {
        if (!$this->request) {
            $this->request = $this->createRequest();
        }
        
        return $this->request;
    }
    
    private function createSession() {
        $session = new Session();
        $session->setId(session_id());
        
        return $session;
    }
    
    private function createRequest() {
        $builder = new HTTPRequestBuilder();
        $builder->setMethod(filter_input(INPUT_SERVER, 'REQUEST_METHOD'))
                ->setScheme(filter_input(INPUT_SERVER, 'REQUEST_SCHEME'))
                ->setHost(filter_input(INPUT_SERVER, 'HTTP_HOST'))
                ->setPort(filter_input(INPUT_SERVER, 'SERVER_PORT'))
                ->setURI(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL))
                ->setVersion(filter_input(INPUT_SERVER, 'SERVER_PROTOCOL'));
        
        foreach (filter_input_array(INPUT_SERVER) as $key => $value) {
            $matches = array();
            if (preg_match('/^(HTTP|CONTENT)_(.*)/', $key, $matches)) {
                $header = str_replace('_', '-', $matches[1] == 'HTTP' ? $matches[2] : $matches[0]);
                $builder->addHeader($header, $value);
            }
        }
        
        $input = FileInputStream::readAll('php://input');
        if ($input) {
            $file = $this->createTempFile();
            FileOutputStream::writeAll($file, $input);

            $in = new FileInputStream($file);
            $builder->setBody($in);
        }
        
        return $builder->build();
    }
    
    public function createTempFile() {
        $path = tempnam($this->context->getProperty('temp_directory'), 'tmp');
        if ($path !== false) {
            $file = new File($path);
            $this->tempFiles[] = $file;
            
            return $file;
        } else {
            return null;
        }
    }
    
    public function __destruct() {
        $in = $this->request ? $this->request->getBody() : null;
        if ($in) {
            $in->close();
        }
        
        foreach ($this->tempFiles as $tempFile) {
            $tempFile->delete();
        }
    }
}
