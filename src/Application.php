<?php

namespace ndebugs\fall;

use Composer\Autoload\ClassLoader;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPManager;
use ndebugs\fall\routing\RouteManager;

class Application {
    
    private static $application;
    private $context;
    
    private function __construct(ApplicationContext $context) {
        $this->context = $context;
    }
    
    public function getContext() {
        return $this->context;
    }

    private function process() {
        $httpManager = $this->context->getComponent(HTTPManager::class);
        $request = $httpManager->getRequest();
        $response = $httpManager->createResponse();
        
        $routeManager = $this->context->getComponent(RouteManager::class);
        $routeManager->process($request, $response);
    }
    
    public static function getInstance() {
        return Application::$application;
    }
    
    public static function init(ClassLoader $classLoader, $properties) {
        $context = new ApplicationContext($classLoader, $properties);
        Application::$application = new Application($context);
        Application::$application->process();
    }
}
