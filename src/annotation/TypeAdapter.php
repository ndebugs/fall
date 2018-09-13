<?php

namespace ndebugs\fall\annotation;

abstract class TypeAdapter extends Component {
    
    public abstract function hasType($type);
}
