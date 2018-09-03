<?php

namespace ndebugs\fall\adapter;

interface TypeAdapter {
    
    public function unmarshall($value);
    
    public function marshall($value);
}