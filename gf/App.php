<?php
namespace GF;
include_once 'Loader.php';

class App {
        private static $_instance = null;
        private $_config = null;
        private $_frontController;
        private $router = null;
    
        private function __construct () {
                $namespace = "GF";
                $path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
                
                \GF\Loader::registerNamespace($namespace, $path);
                \GF\Loader::registerAutoload();
                $this->_config = \GF\Config::getInstance();
                
                if ($this->_config->getConfigFolder() == null) {
                        $this->_config->setConfigFolder('../config');
                }
        }
    
        public function setConfigFolder ($path) {
                $this->_config->setConfigFolder($path);
        }
    
        public function getConfigFolder () {
                return $this->_config->_configFolder;
        }
    
        public function getRouter () {
                return $this->router;
        }
    
        public function setRouter ($router) {
                $this->router = $router;
        }
    
        /*
                @return type: \GF\Config
        */
        public function getConfig () {
                return $this->_config;
        }
    
        public function run () {
                if ($this->_config->getConfigFolder() == null) {
                        $this->_config->_setConfigFolder('../config');
                }
            
                $this->_frontController = \GF\FrontController::getInstance();
                
                if ($this->router instanceof \GF\Routers\IRouter) {
                        $this->_frontController->setRouter($this->router);
                }
                else if ($this->router == 'JsonRPCRouter') {
                        // TODO: fix it when RPC is done
                        $this->_frontController->setRouter(new \GF\Routers\DefaultRouter());
                }
                else if ($this->router == 'CLIRouter') {
                        // TODO: fix it when RPC is done
                        $this->_frontController->setRouter(new \GF\Routers\DefaultRouter());
                }
                else {
                        $this->_frontController->setRouter(new \GF\Routers\DefaultRouter());
                }
                
                $this->_frontController->dispatch();
        }
    
        public static function getInstance () {
                if (self::$_instance == null) {
                       self:: $_instance = new \GF\App();
                }
            
                return self::$_instance;
        }
}