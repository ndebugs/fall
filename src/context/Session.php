<?php

namespace ndebugs\fall\context;

class Session {
    
    /** @var string */
    private $id;
    
    /** @return string */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }
}
