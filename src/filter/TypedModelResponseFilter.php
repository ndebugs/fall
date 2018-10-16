<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\adapter\DataTypeAdapter;
use ndebugs\fall\adapter\DocumentTypeAdapter;
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
     * @return string
     */
    private function toString(TypedModel $model) {
        $value = $model->getValue();
        $type = is_object($value) ? get_class($value) : null;
        $dataAdapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $type, gettype($value));
        $adaptedValue = $dataAdapter ? $dataAdapter->uncast($value, $type) : $value;
        
        $documentAdapter = $this->context->getTypeAdapter(DocumentTypeAdapter::class, $model->getType());
        return $documentAdapter ? $documentAdapter->toString($adaptedValue) : null;
    }
    
    /**
     * @param HTTPResponse $response
     * @param mixed $value
     * @return void
     */
    public function filter(HTTPResponse $response, $value) {
        $response->setContentType($value->getType());
        
        $stringValue = $this->toString($value);
        
        ob_end_clean();
        
        $out = $response->getContent();
        $out->write($stringValue);
    }
}
