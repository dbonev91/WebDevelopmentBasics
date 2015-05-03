<?php

namespace Controllers;

class Index {
    public function index3() {
        $view = \GF\View::getInstance();
        $view->username = 'dbonev';
        $view->appendToLayout('body', 'admin.index');
        $view->appendToLayout('body2', 'index');
        $view->display('layouts.admin.default', array('c' => array(1, 3, 5, 7, 9)));
    }
}