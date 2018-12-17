<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\reflection\XClass;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Component {

    /** @return XClass */
    public function getListenerClass() {
        return null;
    }
}
