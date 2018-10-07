<?php

namespace ndebugs\fall\annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class Roles {

    /** @var string[] */
    public $values;
}
