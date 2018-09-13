<?php

namespace ndebugs\fall\http;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\io\FileInputStream;
use ndebugs\fall\io\FileManager;
use ndebugs\fall\io\FileOutputStream;
use ndebugs\fall\io\StandardInputStream;
use ndebugs\fall\io\StandardOutputStream;

/** @Component */
class HTTPManager {
    
    /** @Autowired(ApplicationContext::class) */
    public $context;
    
    /** @Autowired(FileManager::class) */
    public $fileManager;
    
    private $request;
    
    public function getRequest() {
        if (!$this->request) {
            $this->request = $this->createRequest();
        }
        
        return $this->request;
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
        
        $input = StandardInputStream::readAll();
        if ($input) {
            $file = $this->fileManager->createTempFile('in');
            FileOutputStream::writeAll($file, $input);

            $in = new FileInputStream($file);
            $builder->setContent($in);
        }
        
        return $builder->build();
    }
    
    public function createResponse() {
        $response = new HTTPResponse();
        
        $out = new StandardOutputStream();
        $response->setContent($out);
        
        return $response;
    }
}
