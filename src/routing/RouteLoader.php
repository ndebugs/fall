<?php

namespace ndebugs\fall\routing;

use ReflectionMethod;
use ndebugs\fall\annotation\RequestAttribute;
use ndebugs\fall\annotation\RequestMap;
use ndebugs\fall\annotation\ResponseAttribute;
use ndebugs\fall\annotation\Roles;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\reflection\XMethod;
use ndebugs\fall\routing\RouteGroup;

class RouteLoader {
    
    /** @var ApplicationContext */
    private $context;
    
    /** @var RouteGroup */
    private $group;
    
    /**
     * @param ApplicationContext $context
     * @param RouteGroup $group
     */
    public function __construct(ApplicationContext $context, RouteGroup $group) {
        $this->context = $context;
        $this->group = $group;
    }

	/**
	 * @param XMethod $method
	 * @return Route
	 */
    public function load(XMethod $method) {
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
    
	/** @return Route[] */
    public function loadAll() {
        $class = $this->group->getClass();
        
        $routes = [];
        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $route = $this->load($method);
            if ($route) {
                $routes[] = $route;
            }
        }
        return $routes;
    }
}
