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
    
    /** @var Session */
    private $session;
    
    /** @return Session */
    public function getSession() {
        if (!$this->session) {
            $this->session = $this->createSession();
        }
        
        return $this->session;
    }
    
    /** @return Session */
    private function createSession() {
        $session = new Session();
        $session->setId(session_id());
        
        return $session;
    }
}
