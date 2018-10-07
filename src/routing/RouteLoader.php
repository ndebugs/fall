<?php

namespace ndebugs\fall\routing;

use ndebugs\fall\annotation\RequestAttribute;
use ndebugs\fall\annotation\RequestMap;
use ndebugs\fall\annotation\ResponseAttribute;
use ndebugs\fall\annotation\Roles;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\reflection\MetaMethod;
use ndebugs\fall\routing\RouteGroup;

class RouteLoader {
    
    private $context;
    private $group;
    
    public function __construct(ApplicationContext $context, RouteGroup $group) {
        $this->context = $context;
        $this->group = $group;
    }

    public function load(MetaMethod $method) {
        $requestMap = $method->getAnnotation($this->context, RequestMap::class);
        if ($requestMap) {
            $builder = new RouteBuilder();
            
            $roles = $method->getAnnotation($this->context, Roles::class);
            $builder->setGroup($this->group)
                    ->setAction($method)
                    ->setRequestMap($requestMap)
                    ->setRoles($roles);
            
            $annotations = $method->getAnnotations($this->context);
            foreach ($annotations as $annotation) {
                if ($annotation instanceof RequestAttribute) {
                    $builder->addRequestAttribute($annotation);
                } else if ($annotation instanceof ResponseAttribute) {
                    $builder->setResponseAttribute($annotation);
                }
            }
            
            return $builder->build();
        } else {
            return null;
        }
    }
    
    public function loadAll() {
        $reflection = $this->group->getMetadata();
        
        $routes = [];
        foreach ($reflection->getMetaMethods() as $method) {
            $route = $this->load($method);
            if ($route) {
                $routes[] = $route;
            }
        }
        return $routes;
    }
}
