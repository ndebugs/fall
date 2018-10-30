<?php

namespace ndebugs\fall\util;

final class Objects {

    private function __construct() {}

    /**
     * @param string $type
     * @return string
     */
    public static function normalizeType($type) {
        switch ($type) {
            case 'bool':
                return 'boolean';
            case 'int':
                return 'integer';
            case 'float':
            case 'real':
                return 'double';
            default:
                return $type;
        }
    }
}
