<?php

namespace Controllers;

class Index extends \GF\DefaultController {
    public function index3() {
        $this->app->displayError(404);
        exit;
        
        $val = new \GF\Validation();
        $val->setRule('custom', 5, function ($a) {
            echo $a;
        });
        var_dump($val->validate());
        print_r($val->getErrors());
        
        $view = \GF\View::getInstance();
        $view->username = 'dbonev';
        $view->appendToLayout('body', 'admin.index');
        $view->appendToLayout('body2', 'index');
        $view->display('layouts.admin.default', array('c' => array(1, 3, 5, 7, 9)));
    }
}