<?php
namespace GF;

final class Loader {
        private static $namespaces = array();
    
        private function __construct () {
        }
    
        public static function registerAutoload () {
                $autoloadObj = array("\GF\Loader", "autoload");
                spl_autoload_register($autoloadObj);
        }
    
        public static function autoload ($class) {
                self::loadClass($class);
        }
    
        public static function loadClass ($class) {
                foreach (self::$namespaces as $key => $value) {
                        if (strpos($class, $key) === 0) {
                                $file = substr_replace($class, $value, 0, strlen($key)) . '.php';
                                $isRealPath = realpath($file);
                                
                                if ($isRealPath && is_readable($isRealPath)) {
                                        include $file;
                                }
                                else {
                                        // TODO
                                        throw new invalidargumentexception("File cannot be included: " . $file);
                                }
                            
                                break;
                        }
                }
        }
    
        public static function registerNamespace ($namespace, $path) {
                $namespace = trim($namespace);
                
                if (strlen($namespace) > 0) {
                        if ($path) {
                                $_path = realpath($path);
                                $isRealPath = $_path && is_dir($_path) && is_readable($_path);

                                if ($isRealPath) {
                                        self::$namespaces[$namespace . DIRECTORY_SEPARATOR] = $_path . DIRECTORY_SEPARATOR;
                                }
                                else {
                                        // TODO
                                        throw new invalidargumentexception("Namespace dir read error: " . $path);
                                }   
                        }
                        else {
                                throw new invalidargumentexception("Invalid path: " . $path);
                        }
                }
                else {
                        // TODO: main catching and do somethings with errors
                        throw new invalidargumentexception("Invalid namespace: " . $namespace);
                }
        }
    
        public static function registerNamespaces ($namespacesArray) {
                if (is_array($namespacesArray)) {
                        foreach ($namespacesArray as $namespaceKey => $namespaceValue) {
                                self::registerNamespace ($namespaceKey, $namespaceValue);
                        }
                }
                else {
                        throw new invalidargumentexception("Invalid namespaces: " . $namespacesArray);
                }
        }
    
        public static function getNamespaces () {
                return self::$namespaces;
        }
    
        public static function removeNamespaces ($namespace) {
                unset(self::$namespaces[$namespace]);
        }
    
        public static function clearNamespaces () {
                self::$namespaces = array();
        }
}