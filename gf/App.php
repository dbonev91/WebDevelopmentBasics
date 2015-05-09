<?php
namespace GF;
include_once 'Loader.php';

class App {
        private static $_instance = null;
        private $_config = null;
        private $_frontController;
        private $router = null;
        private $_dbConnectionsArray = array();
        private $_session = null;
    
        private function __construct () {
            set_exception_handler(array($this, '_exceptionHandler'));
        
            $namespace = "GF";
            $path = dirname(__FILE__) . '/';
            
            \GF\Loader::registerNamespace($namespace, $path);
            \GF\Loader::registerAutoload();
            $this->_config = \GF\Config::getInstance();
            
            if ($this->_config->getConfigFolder() == null) {
                // $this->_config->setConfigFolder('../config');
                $this->_config->setConfigFolder('gftest/config');
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
                        $this->_config->setConfigFolder('gftest/config');
                        // $this->_config->setConfigFolder('../config');
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
                
                $_sess = $this->_config->app['session'];
                if ($_sess['autostart']) {
                    if ($_sess['type'] == 'native') {
                        $_s = new \GF\Session\NativeSession(
                            $_sess['name'],
                            $_sess['lifetime'],
                            $_sess['path'],
                            $_sess['domain'],
                            $_sess['secure']
                        );
                    }
                    else if ($_sess['type'] == 'database') {
                        $_s = new \GF\Session\DBSession(
                            $_sess['dbConnection'],
                            $_sess['name'],
                            $_sess['dbTable'],
                            $_sess['lifetime'],
                            $_sess['path'],
                            $_sess['domain'],
                            $_sess['secure']
                        );
                    }
                    else {
                        throw new \Exception("No valid session", 500);
                    }
                    
                    $this->setSession($_s);
                }
                
                $this->_frontController->dispatch();
        }
        
        public function setSession (\GF\Session\ISession $session) {
            $this->_session = $session;
        }
        
        /*
            @return \GF\Session\ISession 
        */
        public function getSession () {
            return $this->_session;
        }
        
        public function getDBConnection ($connection = 'default') {
            if (!$connection) {
                throw new \Exception('No connection identifier prvident', 500);
            }
            
            if ($this->_dbConnectionsArray[$connection]) {
                return $this->_dbConnectionsArray[$connection];
            }
            
            $_cnf = $this->getConfig()->database;
            if (!$_cnf[$connection]) {
                throw new \Exception("No valid connection identifier provided!", 500);
            }
            
            $dbh = new \PDO(
                $_cnf[$connection]['connection_uri'],
                $_cnf[$connection]['username'],
                $_cnf[$connection]['password'],
                $_cnf[$connection]['pdo_options']);
                
                $this->_dbConnectionsArray[$connection] = $dbh;
                
                return $dbh;
        }
    
        public static function getInstance () {
                if (self::$_instance == null) {
                       self:: $_instance = new \GF\App();
                }
            
                return self::$_instance;
        }
        
        public function _exceptionHandler(\Exception $exception) {
            echo $exception;
            if ($this->_config && $this->_config->app['displayExceptions'] == true) {
                echo '<pre>' . print_r($exception, true) . '</pre>';
            }
            else {
                $this->displayError($exception->getCode());
            }
        }
        
        public function displayError($error) {
            try {
                $view = \GF\View::getInstance();
                $view->display('errors.' . $error);
            }
            catch (\Exception $exception) {
                \GF\Common::headerStatus($error);
                echo '<h1>' . $error . '</h1>';
                exit;
            }
        }
        
        public function __destruct() {
            if ($this->_session != null) {
                $this->_session->saveSession();
            }
        }
}