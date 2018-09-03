<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class DataTypeAdapter extends Component {
    
    /** @var string */
    public $type;
}