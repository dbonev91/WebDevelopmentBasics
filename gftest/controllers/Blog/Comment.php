<?php
namespace Controllers\Blog;

include_once 'gftest/Protector.php';
    
class Comment extends \GF\DefaultController {
	public function addCommentForm () {
		$this->view->prefix = '/gftest/public';
        $this->view->csrf = \Protector::getInstance();
        $this->view->db = new \GF\DB\SimpleDB();
        $this->view->title = "Add comment";
        $this->view->postId = $this->input->get(0);
		
		$this->view->appendToLayout('header', 'layouts.fundamentals.header');
        $this->view->appendToLayout('userbar', 'layouts.blog.user.userbar');
        $this->view->appendToLayout('issuebar', 'layouts.blog.user.issuebar');
        $this->view->appendToLayout('content', 'layouts.blog.comment.add-comment-authorized');
        $this->view->appendToLayout('contacts', 'layouts.defaults.contact-me');
        $this->view->appendToLayout('footer', 'layouts.fundamentals.footer');
        
        $this->view->display('layouts.blog.content');
	}
    
    public function addComment () {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $comment = $this->input->post('comment');
        $postId = $this->input->post('postid');
        $csrfToken = $this->input->post('csrf');
        $db = new \GF\DB\SimpleDB();
        
        $csrf = \Protector::getInstance();
        $csrf::csrfChecker($csrfToken);
        
        $db->prepare("INSERT INTO blog_comments (name, email, commentcontent, post_id, dateadded) VALUES (?, ?, ?, ?, ?)")->
            execute(array($name, $email, $comment, $postId, time()));
            
        $_SESSION['success'] = 'Comment added!';
    }
    
    public function delete () {
        if (isset($_SESSION['admin']) && isset($_SESSION['sessionToken'])) {
            $db = new \GF\DB\SimpleDB();
            $input = $this->input->get(0);
            $protector = \Protector::getInstance();
            
            $protector->checkSessionToken();
            
            $delete = $db->prepare("DELETE FROM blog_comments WHERE id=?")->execute(array($input));
            
            if ($delete->getAffectedRows()) {
                $_SESSION['success'] = 'deleted successfully!';
                header('Location: /blog/post/all');
            }
            else {
                $_SESSION['error'] = 'nothing deleted';
                header('Location: /blog/post/all');
            }
        }
        else {
            throw new \Exception("You should have administration rights to do this");
        }
    }
}