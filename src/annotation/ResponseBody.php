<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\web\TypedModel;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class ResponseBody extends ResponseAttribute {
    
    /** @var string */
    public $type = 'application/json';
    
    public function evaluate(ApplicationContext $context, HTTPResponse $response, $value) {
        return new TypedModel($this->type, $value);
    }
}
