<?php
namespace Controllers;

class Index extends \GF\DefaultController {
    public function index3() {
        /*$this->app->displayError(404);
        exit;*/
        
        /*$val = new \GF\Validation();
        $val->setRule('custom', 5, function ($a) {
            echo $a;
        });
        var_dump($val->validate());
        print_r($val->getErrors());*/
        
        /*$this->view->username = 'dbonev';
        $this->view->appendToLayout('body', 'admin.index');
        $this->view->appendToLayout('body2', 'index');
        $this->view->display('layouts.default2', array('c' => array(1, 3, 5, 7, 9)));*/
    }
    
    public function index() {
        $this->view->db = new \GF\DB\SimpleDB();
        $this->view->prefix = '/gftest/public';
        
        $this->view->appendToLayout('header', 'layouts.fundamentals.header');
        $this->view->appendToLayout('gallery', 'layouts.defaults.gallery-container');
        $this->view->appendToLayout('aboutme', 'layouts.defaults.aboutme-container');
        $this->view->appendToLayout('skills', 'layouts.defaults.skills-and-knowledge');
        $this->view->appendToLayout('contacts', 'layouts.defaults.contact-me');
        $this->view->appendToLayout('footer', 'layouts.fundamentals.footer');
        
        $this->view->display('layouts.home');
    }
}