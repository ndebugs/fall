<?php

namespace ndebugs\fall\context;

use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\Controller;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\net\HTTPRequest;
use ndebugs\fall\net\Path;
use ndebugs\fall\routing\PathEvaluator;
use ndebugs\fall\routing\RequestHandler;
use ndebugs\fall\routing\RouteGroup;
use ndebugs\fall\routing\RouteLoader;
use ndebugs\fall\routing\RouteValidator;

/** @Component */
class RouteManager {
    
    /** @Autowired(ApplicationContext::class) */
    public $context;
    
    /** @Autowired(SessionManager::class) */
    public $sessionManager;
    
    private $routeGroups = [];
    private $routes = [];
    
    /** @PostConstruct */
    public function init() {
        $componentMap = $this->context->getComponentMap(Controller::class);
        foreach ($componentMap as $class => $type) {
            $routeGroup = new RouteGroup();
            $routeGroup->setPath(Path::parseURL($type->path));
            $routeGroup->setController($class);

            $this->routeGroups[$class] = $routeGroup;
        }
    }
    
    public function getRoutes(RouteGroup $routeGroup) {
        if (!isset($this->routes[$routeGroup->getController()])) {
            $loader = new RouteLoader($routeGroup);
            $routes = $loader->loadAll();
            
            return $this->routes[$routeGroup->getController()] = $routes;
        } else {
            return $this->routes[$routeGroup->getController()];
        }
    }
    
    private function evaluateGroup(PathEvaluator $evaluator, $offset, RouteGroup $routeGroup) {
        $path = $routeGroup->getPath();
        $nextOffset = $evaluator->next($path, $offset);
        if ($nextOffset > -1) {
            $routes = $this->getRoutes($routeGroup);
            foreach ($routes as $route) {
                $result = $evaluator->evaluate($route->getPath(), $nextOffset);
                $request = $evaluator->getRequest();
                if ($result !== null && RouteValidator::validateAll($route, $request)) {
                    return new RequestContext($route, $request, $result);
                }
            }
        }
        
        return null;
    }
    
    private function evaluateGroups(PathEvaluator $evaluator) {
        $baseURL = $this->context->getProperty('base_url');
        $basePath = Path::parseURL($baseURL);
        
        $offset = $evaluator->next($basePath);
        if ($offset > -1) {
            foreach ($this->routeGroups as $routeGroup) {
                $result = $this->evaluateGroup($evaluator, $offset, $routeGroup);
                if ($result != null) {
                    return $result;
                }
            }
        }
        
        return null;
    }
    
    public function process(HTTPRequest $request) {
        $evaluator = new PathEvaluator($request);
        $context = $this->evaluateGroups($evaluator);
        if ($context) {
            $handler = new RequestHandler($this->context, $context);
            $result = $handler->process();
        }
    }
}
