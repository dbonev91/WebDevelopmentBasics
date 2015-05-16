<?php
$postId = $this->input->get(0);
	
$postVisits = $this->db->prepare(
	"SELECT visitscount
	FROM blog_posts
	WHERE id=?")->execute(array($postId))->fetchAllAssoc();
	
$updatedVisits = ++$postVisits[0]['visitscount'];

$this->db->prepare("UPDATE blog_posts SET visitscount=? WHERE id=?")->execute(array($updatedVisits, $postId));

$postData = $this->db->prepare(
	"SELECT p.title, p.postcontent, p.dateadded, p.datemodified, u.username, u.id
	FROM blog_posts AS p
	JOIN blog_userposts AS up
	ON p.id=up.post_id
	JOIN blog_users AS u
	ON u.id=up.user_id 
	WHERE p.id=?")->execute(array($postId))->fetchAllAssoc();
	
$postComments = $this->db->prepare(
	"SELECT commentcontent AS comment, name, email, dateadded, id
	FROM blog_comments 
	WHERE post_id=?")->execute(array($postId))->fetchAllAssoc();

include_once 'gftest/models/PostInModel.php';

$postInModel = new \Models\PostInModel($postId, $postData[0]['title'], $postData[0]['dateadded'],
	$postData[0]['postcontent'], $postData[0]['username']);
	
echo $postInModel->drawElement();

$output = "<h3>Comments:</h3>";
 
echo $output;

include_once 'gftest/models/CommentModel.php';

foreach ($postComments as $comment) {
	$commentModel = new \Models\CommentModel($comment['id'], $comment['email'], $comment['dateadded'],
		$comment['comment'], $comment['name']);
		
	echo $commentModel->drawElement();
}