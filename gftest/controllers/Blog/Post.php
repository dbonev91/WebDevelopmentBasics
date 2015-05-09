<?php
namespace Controllers\Blog;

include_once 'gftest/Protector.php';

class Post extends \GF\DefaultController {
	public function addPostForm () {
		$this->view->prefix = '/gftest/public';
        $this->view->csrf = \Protector::getInstance();
		
		$this->view->appendToLayout('header', 'layouts.fundamentals.header');
        $this->view->appendToLayout('userbar', 'layouts.blog.user.userbar');
        if (isset($_SESSION['sessionToken'])) {
            $this->view->appendToLayout('content', 'layouts.blog.post.add-post-authorized');
        }
        else {
            $this->view->appendToLayout('content', 'layouts.blog.post.add-post-unauthorized');
        }
        $this->view->appendToLayout('contacts', 'layouts.defaults.contact-me');
        $this->view->appendToLayout('footer', 'layouts.fundamentals.footer');
        
        $this->view->display('layouts.blog.content');
	}
    
    public function addPost () {
        if (isset($_SESSION['sessionToken'])) {
            $scrf = \Protector::getInstance();
            $scrf->checkSessionToken();
            $db = new \GF\DB\SimpleDB();
            $validate = new \GF\Validation();
            
            $title = $this->input->post('title');
            $content = $this->input->post('content');
            $tags = $this->input->post('tags');
            $scrfToken = $this->input->post('csrf');
        
            $scrf->csrfChecker($scrfToken);
            
            $addPost = $db->prepare("INSERT INTO blog_posts (title, postcontent, dateadded) values (?, ?, ?)")->execute(array($title, $content, time()));
            if ($addPost) {
                $postId = $addPost->getLastInsertId();
                $this->addTags($tags, $postId, $db);
                $userData = $db->prepare("SELECT id FROM blog_users WHERE username=?")->
                    execute(array($scrf->returnValidUser()))->fetchAllAssoc();
                $db->prepare("INSERT INTO blog_userposts (user_id, post_id) VALUES (?, ?)")->
                    execute(array($userData[0]['id'], $postId));
                echo "Post added successfully!";
            }
            else {
                throw new \Exception("Error adding post. Please try again later.");
            }
        }
        else {
            throw new \Exception("you are not logged in!");
        }
    }
    
    public function addTags($tagsString, $postId, $db) {
        $tagsArray = explode(',', $tagsString);
        
        if (count($tagsArray)) {
            foreach ($tagsArray as $tag) {
                $tag = trim($tag);
                $checkCount = $db->prepare("SELECT tagscount, id FROM blog_tags WHERE title=?")->execute(array($tag))->fetchAllAssoc();
                
                if ($checkCount) {
                    $count = $checkCount[0]['tagscount'];
                    $id = $checkCount[0]['id'];
                    
                    $db->prepare("UPDATE blog_tags SET tagscount=? WHERE id=?")->execute(array((++$count), $id));
                    $db->prepare("INSERT INTO blog_posttags (tag_id, post_id) VALUES (?, ?)")->execute(array($id, $postId));
                }
                else {
                    $insertTag = $db->prepare("INSERT INTO blog_tags (title) VALUES (?)")->execute(array($tag));
                    $db->prepare("INSERT INTO blog_posttags (tag_id, post_id) VALUES (?, ?)")->execute(array($insertTag->getLastInsertId(), $postId));
                }
            }
        }
    }
}