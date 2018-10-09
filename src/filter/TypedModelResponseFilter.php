<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\adapter\DocumentTypeAdaptable;
use ndebugs\fall\adapter\ObjectTypeAdaptable;
use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeFilter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\web\TypedModel;

/** @TypeFilter(TypedModel::class) */
class TypedModelResponseFilter implements ResponseFilterable {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @param TypedModel $model
     * @return mixed
     */
    private function marshall(TypedModel $model) {
        $value = $model->getValue();
        $type = get_class($value);
        $dataAdapter = $this->context->getTypeAdapter(ObjectTypeAdaptable::class, $type);
        $adaptedValue = $dataAdapter ? $dataAdapter->unwrap($value) : null;
        
        $documentAdapter = $this->context->getTypeAdapter(DocumentTypeAdaptable::class, $model->getType());
        return $documentAdapter ? $documentAdapter->marshall($adaptedValue) : null;
    }
    
    /**
     * @param HTTPResponse $response
     * @param mixed $value
     * @return void
     */
    public function filter(HTTPResponse $response, $value) {
        $response->setContentType($value->getType());
        
        $marshalledValue = $this->marshall($value);
        
        ob_end_clean();
        
        $out = $response->getContent();
        $out->write($marshalledValue);
    }
}
