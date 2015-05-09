<?php
namespace Controllers\Blog;

include_once 'gftest/Protector.php';

class ViewProfile extends \GF\DefaultController {
	public function viewProfile () {
		$this->view->prefix = '/gftest/public';
        $this->view->csrf = \Protector::getInstance();
        $this->view->userProfile = $this->input->get(0);
		
		$this->view->appendToLayout('header', 'layouts.fundamentals.header');
        $this->view->appendToLayout('userbar', 'layouts.blog.user.userbar');
        $this->view->appendToLayout('content', 'layouts.blog.user.user-profile');
        $this->view->appendToLayout('contacts', 'layouts.defaults.contact-me');
        $this->view->appendToLayout('footer', 'layouts.fundamentals.footer');
        
        $this->view->display('layouts.blog.content');
	}
}