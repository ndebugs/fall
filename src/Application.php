<?php

namespace ndebugs\fall;

use Composer\Autoload\ClassLoader;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\context\RouteManager;
use ndebugs\fall\context\SessionManager;

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
        $routeManager = $this->context->getComponent(RouteManager::class);
        $sessionManager = $this->context->getComponent(SessionManager::class);
        
        $request = $sessionManager->getRequest();
        $routeManager->process($request);
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
