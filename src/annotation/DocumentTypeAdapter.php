<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class DocumentTypeAdapter extends Component {
    
    /** @var array */
    public $types;
}