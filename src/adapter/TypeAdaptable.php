<?php

namespace ndebugs\fall\adapter;

interface TypeAdaptable {
    
    public function unmarshall($value);
    
    public function marshall($value);
}
