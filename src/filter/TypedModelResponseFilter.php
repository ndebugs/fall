<?php

namespace ndebugs\fall\filter;

use ndebugs\fall\adapter\DataTypeAdaptable;
use ndebugs\fall\adapter\DocumentTypeAdaptable;
use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\TypeAdapter;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\reflection\TypeResolver;
use ndebugs\fall\web\TypedModel;

/** @TypeAdapter(TypedModel::class) */
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
        $type = TypeResolver::fromValue($value);
        $dataAdapter = $this->context->getTypeAdapter(DataTypeAdaptable::class, $type);
        $adaptedValue = $dataAdapter ? $dataAdapter->uncast($value, $type) : $value;
        
        $documentAdapter = $this->context->getStaticTypeAdapter(DocumentTypeAdaptable::class, $model->getType());
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
