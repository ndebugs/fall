<?php

namespace ndebugs\fall\validation;

use Exception;

class ValidationException extends Exception {
    
    /** @var ValidationError[] */
    private $errors;
    
    /**
     * @param integer $code
     * @param string $message
     * @param ValidationError[] $errors
     */
    public function __construct($message, array $errors) {
        parent::__construct($message);
        
        $this->errors = $errors;
    }
    
    /** @return ValidationError[] */
    public function getErrors() {
        return $this->errors;
    }
    
    /** @param ValidationError[] $errors */
    public static function forErrors(array $errors) {
        return new ValidationException('Validation Error', $errors);
    }
}
