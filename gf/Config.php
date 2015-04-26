<?php
namespace GF;

class Config {
        private static $_instance = null;
        private $_configArray;
        private $_configFolder;
    
        private function __construct () {
                
        }
    
        public function getConfigFolder () {
                return $this->_configFolder;
        }
    
        public function setConfigFolder ($configFolder) {
                if (!$configFolder) {
                        throw new invalidargumentexception("Invalid config folder: " . $configFolder);
                }
            
                $_configFolder = realpath($configFolder);    
                $isValidConfigFolder = $_configFolder && is_dir($_configFolder) && is_readable($_configFolder);
                
                if ($isValidConfigFolder) {
                        // clear old config data
                        $this->_configArray = array();
                        $this->_configFolder = $_configFolder . DIRECTORY_SEPARATOR;
                    
                        $namespaces = $this->app['namespaces'];
                        
                        if (is_array($namespaces)) {
                                \GF\Loader::registerNamespaces($namespaces);
                        }
                }
                else {
                        throw new invalidargumentexception("Invalid config folder: " . $_configFolder);
                }
        }
    
        public function __get ($name) {
                if (!$this->_configArray[$name]) {
                        $this->includeConfigFile($this->_configFolder . $name . '.php');
                }
            
                if (array_key_exists($name, $this->_configArray)) {
                        return $this->_configArray[$name];
                }
            
                return null;
        }
    
        public function includeConfigFile ($path) {
                if ($path) {
                        $_file = realpath($path);
                        $isValidFile = $_file && is_file($_file) && is_readable($_file);
                    
                        if ($isValidFile) {
                                $_basename = explode('.php', basename($_file))[0];
                                
                                $this->_configArray[$_basename] = include $_file;
                        }
                        else {
                                throw new invalidargumentexception("Config file read error: " . $_file);
                        }
                }
                else {
                        throw new invalidargumentexception("Invalid path: " . $path);
                }
        }
    
        public static function getInstance() {
                if (self::$_instance == null) {
                        self::$_instance = new \GF\Config();
                }

                return self::$_instance;
        }
}