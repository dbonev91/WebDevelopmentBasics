<?php
namespace GF\Routers;

class DefaultRouter implements \GF\Routers\IRouter {
        public function getURI () {
                // return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
                return $_SERVER['QUERY_STRING'];
        }
        
        public function getPost () {
            return $_POST;
        }
}