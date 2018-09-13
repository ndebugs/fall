<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Controller extends Component {
    
    /** @var string */
    public $path = '/';
}
