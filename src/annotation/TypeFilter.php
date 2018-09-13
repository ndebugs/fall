<?php

namespace ndebugs\fall\annotation;

abstract class TypeFilter extends Component {
    
    public abstract function matchType($value);
}
