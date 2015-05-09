<?php
namespace Controllers\Blog;

include_once 'gftest/Protector.php';

class Login extends \GF\DefaultController {
	public function showLoginForm () {
		$this->view->prefix = '/gftest/public';
        $this->view->csrf = \Protector::getInstance();
		
		$this->view->appendToLayout('header', 'layouts.fundamentals.header');
        $this->view->appendToLayout('userbar', 'layouts.blog.user.userbar');
        $this->view->appendToLayout('content', 'layouts.blog.user.login-form');
        $this->view->appendToLayout('contacts', 'layouts.defaults.contact-me');
        $this->view->appendToLayout('footer', 'layouts.fundamentals.footer');
        
        $this->view->display('layouts.blog.content');
	}
    
    public function doLog () {
        if ($_SESSION['user'] || $_SESSION['admin']) {
            throw new \Exception("You are allready loggen in!");
        }
        
        $db = new \GF\DB\SimpleDB();
        $validate = new \GF\Validation();
        $scrf = \Protector::getInstance();
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $scrfToken = $this->input->post('csrf');
        
        $scrf->csrfChecker($scrfToken);
        
        $userData = $db->prepare("SELECT pass, isadmin, id FROM blog_users WHERE username=?")->execute(array($username))->fetchAllAssoc();
        $userData = $userData[0];
        if ($userData) {
            $isValidPassword = password_verify($password, $userData['pass']);
            if ($isValidPassword) {
                switch ($userData['isadmin']) {
                    case 0:
                        $_SESSION['user'] = $username;
                        break;
                    case 1:
                        $_SESSION['admin'] = $username;
                        break;
                    default:
                        throw new \Exception("Probelm validating password");
                }
                
                $_SESSION['sessionToken'] = $scrf->createSessionToken($username, $userData['id']);
                
                // TODO: redirect to blog
            }
            else {
                throw new \Exception("Invalid username or password");
            }
        }
        else {
            throw new \Exception("Invalid username or password");
        }
    }
    
    public function logout () {
        unset ($_SESSION['admin'], $_SESSION['user'], $_SESSION['sessionToken']);
        session_destroy();
        echo 'Logout successfully!';
    }
}