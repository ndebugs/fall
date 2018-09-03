<?php

namespace ndebugs\fall\util;

final class Strings {

    private function __construct() {}

    /**
     * Evaluate if string starts with value
     * @param string $source <p>
     * The source string.
     * </p>
     * @param string $value <p>
     * The value string.
     * </p>
     * @return boolean Returns true if <i>source</i> starts with <i>value</i>.
     */
    public static function startsWith($source, $value) {
        return $value === '' || strrpos($source, $value, -strlen($source)) !== false;
    }

    /**
     * Evaluate if string ends with value
     * @param string $source <p>
     * The source string.
     * </p>
     * @param string $value <p>
     * The value string.
     * </p>
     * @return boolean Returns true if <i>source</i> ends with <i>value</i>.
     */
    public static function endsWith($source, $value) {
        if ($value === '') {
            return true;
        }
        
        $offset = strlen($source) - strlen($value);
        return $offset >= 0 && strpos($source, $value, $offset) !== false;
    }
}
