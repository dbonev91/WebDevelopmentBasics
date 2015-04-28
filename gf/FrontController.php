<?php
namespace GF;

class FrontController {
        private static $_instance;
        private $namespaceValue = null;
        private $controller = null;
        private $method = null;
    
        private function __construct () {
                
        }
    
        public function dispatch () {
                $defaultRouter = new \GF\Routers\DefaultRouter();
                $_uri = $defaultRouter->getURI();
                $routes = \GF\App::getInstance()->getConfig()->routes;
                $_routeControllerArray = null;
            
                if (is_array($routes) && count($routes) > 0) {
                        foreach ($routes as $routeKey => $routeValue) {
                                $isURICorrect = stripos($_uri, $routeKey) === 0 &&
                                        ($_uri == $routeKey || stripos($_uri, $routeKey . '/') === 0) &&
                                        $routeValue['namespace'];
                            
                                if ($isURICorrect) {
                                        $this->namespaceValue = $routeValue['namespace'];
                                        $_uri = substr($_uri, strlen($routeKey) + 1);
                                        $_routeControllerArray = $routeValue;
                                        break;
                                }
                        }
                }
                else {
                        throw new exception("Default route missing!", 500);
                }
            
                if ($this->namespaceValue == null && $routes['*']['namespace']) {
                        $this->namespaceValue = $routes['*']['namespace'];
                        $_routeControllerArray = $routes['*'];
                }
                else if ($this->namespaceValue == null && !$routes['*']['namespace']) {
                        throw new exception("Default route missing", 500);
                }
            
                $_params = explode('/', $_uri);
                
                if ($_params[0]) {
                        $this->controller = strtolower($_params[0]);
                        if ($_params[1]) {
                                $this->method = strtolower($_params[1]);
                        }
                        else {
                                $this->method = $this->getDefaultMethod();
                        }
                }
                else {
                        $this->controller = $this->getDefaultController();
                        $this->method = $this->getDefaultMethod();
                }
            
                if (is_array($_routeControllerArray) && $_routeControllerArray['controllers']) {
                        if ($_routeControllerArray['controllers'][$this->controller]['methods'][$this->method]) {
                                $this->method = strtolower($_routeControllerArray['controllers'][$this->controller]['methods'][$this->method]);
                        }
                        
                        if (isset($_routeControllerArray['controllers'][$this->controller]['to'])) {
                                $this->controller = strtolower($_routeControllerArray['controllers'][$this->controller]['to']);
                        }
                }
            
                $namespaceAndController = $this->namespaceValue . '\\' . ucfirst($this->controller);
                $newController = new $namespaceAndController();
                $newController->{$this->method}();
        }
    
        public function getDefaultController () {
                $defaultControllerKey = 'default_controller';
                $controller = \GF\App::getInstance()->getConfig()->app[$defaultControllerKey];
                if ($controller) {
                        return strtolower($controller);
                }
            
                return "index";
        }
    
        public function getDefaultMethod () {
                $defaultMethodKey = 'default_method';
                $method = \GF\App::getInstance()->getConfig()->app[$defaultMethodKey];
                if ($method) {
                        return strtolower($method);
                }
            
                return "index";
        }
    
        public static function getInstance () {
                if (self::$_instance == null) {
                        self::$_instance = new \GF\FrontController();
                }
                
                return self::$_instance;
        }
}