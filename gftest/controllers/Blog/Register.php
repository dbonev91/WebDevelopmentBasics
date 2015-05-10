<?php
namespace Controllers\Blog;

include_once 'gftest/Protector.php';

class Register extends \GF\DefaultController {
    
	public function showRegisterForm () {
        $this->view->prefix = '/gftest/public';
        $this->view->csrf = \Protector::getInstance();
        $this->view->db = new \GF\DB\SimpleDB();
		
		$this->view->appendToLayout('header', 'layouts.fundamentals.header');
        $this->view->appendToLayout('userbar', 'layouts.blog.user.userbar');
        $this->view->appendToLayout('issuebar', 'layouts.blog.user.issuebar');
        $this->view->appendToLayout('content', 'layouts.blog.user.register-form');
        $this->view->appendToLayout('contacts', 'layouts.defaults.contact-me');
        $this->view->appendToLayout('footer', 'layouts.fundamentals.footer');
        
        $this->view->display('layouts.blog.content');
	}
    
    public function doReg () {
		$db = new \GF\DB\SimpleDB();
        $validate = new \GF\Validation();
        $scrf = \Protector::getInstance();
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $repeatPassword = $this->input->post('repeatPassword');
        $email = $this->input->post('email');
        $scrfToken = $this->input->post('csrf');
        
        $scrf->csrfChecker($scrfToken);
        $this->checkExists($username, $db, 'username');
        $this->checkExists($email, $db, 'email');
        
        $isValidUserData = $this->checkUsername($username, $validate) &&
            $this->comparePasswordsPassword($password, $repeatPassword, $validate) &&
            $this->checkPassLength($password, $validate) && 
            $this->checkEmail($email, $validate);
            
        if ($isValidUserData) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $register = $db->prepare('INSERT INTO blog_users (username, pass, email) VALUES (?, ?, ?)')->execute(array($username, $hashedPassword, $email));
            if ($register) {
                $_SESSION['user'] = $username;
                $_SESSION['sessionToken'] = $scrf->createSessionToken ($username, $register->getLastInsertId());
                $_SESSION['success'] = 'Register successfully!';
                
                // TODO: redirect to blog
            }
            else {
                $_SESSION['error'] = "Register error: please try again later.";
                throw new \Exception("Register error: please try again later.");
            }
        }
    }
    
    public function checkExists ($val, $db, $property) {
        $isExists = $db->prepare("SELECT {$property} FROM blog_users WHERE {$property}=?")->execute(array($val));
        if ($isExists->getAffectedRows()) {
        $_SESSION['error'] = "$property allready taken";
            throw new \Exception("$property allready taken");
        }
    }
    
    public function checkUsername ($username, $validationClass) {
        $validationClass->setRule('minlength', $username, 3)->setRule('maxlength', $username, 45);
        if ($validationClass->validate()) {
            return true;
        }
        
        $_SESSION['error'] = "username shoud be bethween 3 and 45 symbols length!";
        throw new \Exception("username shoud be bethween 3 and 45 symbols length!");
    }
    
    public function comparePasswordsPassword ($pass, $repeatPass, $validationClass) {
        $validationClass->setRule('matches', $pass, $repeatPass);
        if ($validationClass->validate()) {
            return true;
        }
        
        $_SESSION['error'] = "passwords do not match";
        throw new \Exception("passwords do not match");
    }
    
    public function checkPassLength ($pass, $validationClass) {
        $validationClass->setRule('minlength', $pass, 6);
        if ($validationClass->validate()) {
            return true;
        }
        
        $_SESSION['error'] = "passowrd should be 6 symbols at least";
        throw new \Exception("passowrd should be 6 symbols at least");
    }
    
    public function checkEmail ($email, $validationClass) {
        $validationClass->setRule('email', $email);
        if ($validationClass->validate()) {
            return true;
        }
        
        $_SESSION['error'] = "Incorrect email!";
        throw new \Exception("incorrect email");
    }
}