<?php

namespace ndebugs\fall;

use Composer\Autoload\ClassLoader;
use ndebugs\fall\context\ApplicationContext;
use ndebugs\fall\http\HTTPManager;
use ndebugs\fall\routing\RouteManager;

class Application {
    
    /** @var Application */
    private static $application;
    
    /** @var ApplicationContext */
    private $context;
    
    /** @param ApplicationContext $context */
    private function __construct(ApplicationContext $context) {
        $this->context = $context;
    }
    
    /** @return ApplicationContext */
    public function getContext() {
        return $this->context;
    }

    /** @return void */
    private function process() {
        $httpManager = $this->context->getComponent(HTTPManager::class);
        $request = $httpManager->getRequest();
        $response = $httpManager->createResponse();
        
        $routeManager = $this->context->getComponent(RouteManager::class);
        $routeManager->process($request, $response);
    }
    
    /** @return Application */
    public static function getInstance() {
        return Application::$application;
    }
    
    /**
     * @param ClassLoader $classLoader
     * @param array $properties
     * @return void
     */
    public static function init(ClassLoader $classLoader, array $properties) {
        $context = new ApplicationContext($classLoader, $properties);
        Application::$application = new Application($context);
        Application::$application->process();
    }
}
