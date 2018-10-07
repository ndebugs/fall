<?php

namespace ndebugs\fall\context;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;

/** @Component */
class SessionManager {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    private $session;
    
    public function getSession() {
        if (!$this->session) {
            $this->session = $this->createSession();
        }
        
        return $this->session;
    }
    
    private function createSession() {
        $session = new Session();
        $session->setId(session_id());
        
        return $session;
    }
}
