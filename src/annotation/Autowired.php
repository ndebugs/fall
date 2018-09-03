<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Autowired {
    
    /**
     * @var string
     * @Required
     */
    public $type;
}