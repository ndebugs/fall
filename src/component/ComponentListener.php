<?php

namespace ndebugs\fall\component;

use Exception;

interface ComponentListener {
    
    /** @return void */
    public function onPreCall();
    
    /** @return void */
    public function onPostCall();
    
    /**
     * @param Exception $e
     * @return void
     */
    public function onError(Exception $e);
}
