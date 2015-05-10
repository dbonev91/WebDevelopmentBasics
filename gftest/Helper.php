<?php
class Helper extends \GF\DefaultController {
	private static $_instance = null;
	
	private function __construct () {
		
	}
	
	public static function layoutExtender ($layout) {
		$this->view->appendToLayout('header', 'layouts.fundamentals.header');
        $this->view->appendToLayout('userbar', 'layouts.blog.user.userbar');
        $this->view->appendToLayout('issuebar', 'layouts.blog.user.issuebar');
        $this->view->appendToLayout('content', $layout);
        $this->view->appendToLayout('contacts', 'layouts.defaults.contact-me');
        $this->view->appendToLayout('footer', 'layouts.fundamentals.footer');
        
        $this->view->display('layouts.blog.content');
	}
	
	public function getInstance () {
		if (self::$_instance == null) {
			self::$_instance = new \Helper();
		}
		
		return self::$_instance;
	}
}