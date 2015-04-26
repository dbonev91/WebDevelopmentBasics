<?php
namespace GF;

class FrontController {
        private static $_instance;
    
        private function __construct () {
                
        }
    
        public function dispatch () {
                $defaultRouter = new \GF\Routers\DefaultRouter();
                $defaultRouter->parse();
        }
    
        public static function getInstance () {
                if (self::$_instance == null) {
                        self::$_instance = new \GF\FrontController();
                }
                
                return self::$_instance;
        }
}