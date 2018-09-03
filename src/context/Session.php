<?php

namespace ndebugs\fall\context;

class Session {
    
    private $id;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
}
