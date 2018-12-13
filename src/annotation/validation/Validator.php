<?php

namespace ndebugs\fall\annotation\validation;

use ndebugs\fall\reflection\XClass;
use ndebugs\fall\util\Strings;
use ndebugs\fall\validation\Validatable;

abstract class Validator implements Validatable {
    
    /** @var string */
    public $message;
    
    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public abstract function getDefaultMessage($name, $value);
    
    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public function getMessage($name, $value) {
        if ($this->message) {
            $class = new XClass($this);
            $properties = $class->getProperties();
            $arguments = [
                '${name}' => $name,
                '${value}' => $value
            ];
            foreach ($properties as $property) {
                $arguments['${_' . $property->getName() . '}'] = $property->getValue($this);
            }
            return strtr($this->message, $arguments);
        } else {
            return $this->getDefaultMessage($name, $value);
        }
    }
    
    /**
     * @param string $value
     * @return boolean
     */
    public abstract function validate($value);
}
