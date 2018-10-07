<?php

namespace ndebugs\fall\routing;

use Exception;
use ndebugs\fall\annotation\Autowired;
use ndebugs\fall\annotation\Component;
use ndebugs\fall\annotation\Controller;
use ndebugs\fall\annotation\PostConstruct;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RequestContext;
use ndebugs\fall\http\HTTPManager;
use ndebugs\fall\http\HTTPRequest;
use ndebugs\fall\http\HTTPResponse;
use ndebugs\fall\http\RequestHandler;
use ndebugs\fall\http\ResponseHandler;
use ndebugs\fall\net\Path;
use ndebugs\fall\routing\PathEvaluator;
use ndebugs\fall\routing\RouteGroup;
use ndebugs\fall\routing\RouteLoader;
use ndebugs\fall\routing\RouteValidator;
use ndebugs\fall\web\HTTPNotFoundException;

/** @Component */
class RouteManager {
    
    /**
     * @var ApplicationContext
     * @Autowired
     */
    public $context;
    
    /**
     * @var HTTPManager
     * @Autowired
     */
    public $httpManager;
    
    private $routeGroups = [];
    private $routes = [];
    
    /** @PostConstruct */
    public function init() {
        $contexts = $this->context->getComponentContexts(Controller::class);
        foreach ($contexts as $context) {
            $type = $context->getType();
            
            $routeGroup = new RouteGroup();
            $routeGroup->setMetadata($context->getReflection());
            $routeGroup->setPath(Path::parseURL($type->path));

            $this->routeGroups[] = $routeGroup;
        }
    }
    
    public function getRoutes(RouteGroup $routeGroup) {
        $class = $routeGroup->getMetadata()->getName();
        if (!isset($this->routes[$class])) {
            $loader = new RouteLoader($this->context, $routeGroup);
            $routes = $loader->loadAll();
            
            return $this->routes[$class] = $routes;
        } else {
            return $this->routes[$class];
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
    
    public function process(HTTPRequest $request, HTTPResponse $response) {
        $result = null;
        $responseAttribute = null;
        
        try {
            $evaluator = new PathEvaluator($request);
            $context = $this->evaluateGroups($evaluator);
            if ($context) {
                $route = $context->getRoute();
                $responseAttribute = $route->getResponseAttribute();

                $requestHandler = new RequestHandler($this->context, $context);
                $requestHandler->setTypeArgument($request);
                $requestHandler->setTypeArgument($response);

                $result = $requestHandler->process();
            } else {
                $result = new HTTPNotFoundException('The requested URL ' . $request->getURL() . ' was not found on this server.');
            }
        } catch (Exception $e) {
            $result = $e;
        }
        
        $responseHandler = new ResponseHandler($this->context, $response);
        $responseHandler->process($result, $responseAttribute);
    }
}
