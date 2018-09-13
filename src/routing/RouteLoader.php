<?php

namespace ndebugs\fall\routing;

use ReflectionClass;
use ReflectionMethod;
use Doctrine\Common\Annotations\AnnotationReader;
use ndebugs\fall\annotation\RequestAttribute;
use ndebugs\fall\annotation\RequestMap;
use ndebugs\fall\annotation\ResponseAttribute;
use ndebugs\fall\annotation\Roles;
use ndebugs\fall\routing\RouteGroup;

class RouteLoader {
    
    private $group;
    
    public function __construct(RouteGroup $group) {
        $this->group = $group;
    }

    public function load(AnnotationReader $reader, ReflectionMethod $method) {
        $requestMap = $reader->getMethodAnnotation($method, RequestMap::class);
        if ($requestMap) {
            $builder = new RouteBuilder();
            
            $roles = $reader->getMethodAnnotation($method, Roles::class);
            $builder->setGroup($this->group)
                    ->setAction($method)
                    ->setRequestMap($requestMap)
                    ->setRoles($roles);
            
            $annotations = $reader->getMethodAnnotations($method);
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
        $reflection = new ReflectionClass($this->group->getController());
        $reader = new AnnotationReader();
        
        $routes = [];
        foreach ($reflection->getMethods() as $method) {
            $route = $this->load($reader, $method);
            if ($route) {
                $routes[] = $route;
            }
        }
        return $routes;
    }
}
