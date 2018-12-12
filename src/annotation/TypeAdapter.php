<?php

namespace ndebugs\fall\annotation;

use ndebugs\fall\reflection\TypeResolver;
use ndebugs\fall\reflection\type\Type;
use ndebugs\fall\reflection\type\TypeComparable;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class TypeAdapter extends Component {
    
    /**
     * @var string[]
     * @Required
     */
    public $types;
    
    /**
     * @param Type $type
     * @param Type $anotherType [optional]
     * @return Type
     */
    private function compare(Type $type, Type $anotherType = null) {
        if ($anotherType) {
            $result = $type->compare($anotherType);
            if ($result == TypeComparable::GREATER_THAN) {
                return $anotherType;
            }
        }
        
        return $type;
    }
    
    /**
     * @param Type $type
     * @param Type $defaultType [optional]
     * @return Type
     */
    public function matches(Type $type, Type $defaultType = null) {
        $matchType = null;
        foreach ($this->types as $tString) {
            $t = TypeResolver::fromString($tString);
            if (!$t) {
                continue;
            }
            
            $result = $t->compare($type);
            if ($result == TypeComparable::EQUAL) {
                return $type;
            } else if ($result == TypeComparable::GREATER_THAN) {
                $matchType = $this->compare($t, $matchType ? $matchType : $defaultType);
            }
        }
        
        return $matchType;
    }
}
