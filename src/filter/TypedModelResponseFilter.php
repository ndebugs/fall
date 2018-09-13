<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\DataTypeAdapter;
use ndebugs\fall\annotation\DocumentTypeAdapter;
use ndebugs\fall\annotation\ResponseFilter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\web\TypedModel;

/** @ResponseFilter(TypedModel::class) */
class TypedModelResponseFilter implements ResponseFilterable {
    
    /** @Autowired(ApplicationContext::class) */
    public $context;
    
    private function marshall(TypedModel $model) {
        $value = $model->getValue();
        $type = is_object($value) ? get_class($value) : gettype($value);
        $dataAdapter = $this->context->getTypeAdapter(DataTypeAdapter::class, $type);
        $adaptedValue = $dataAdapter ? $dataAdapter->marshall($value) : null;
        
        $documentAdapter = $this->context->getTypeAdapter(DocumentTypeAdapter::class, $model->getType());
        return $documentAdapter ? $documentAdapter->marshall($adaptedValue) : null;
    }
    
    public function filter(HTTPResponse $response, $value) {
        $response->setContentType($value->getType());
        
        $marshalledValue = $this->marshall($value);
        
        ob_end_clean();
        
        $out = $response->getContent();
        $out->write($marshalledValue);
    }
}
