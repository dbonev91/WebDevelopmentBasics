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
	
$output = "<h2>" . htmlentities($postData[0]['title']) . "</h2>";
if (isset($_SESSION['admin'])) {
	$output .= "<a href='/blog/post/delete/" . $postId . "'>[X]</a>";
}
$output .= "<div class='postBody singlePost'>";
$output .= "<div class='postHeaders'>";
$output .= "<span class='dateAdded'>" . date('d.m.Y', $postData[0]['dateadded']) . "</span>";
$output .= " - ";
$output .= "<span class='addedFrom'><a href='/blog/profile/view/" . $postData[0]['username'] . "'>" . $postData[0]['username'] . "</a></span>";
$output .= "</div>";
$output .= "<div class='postContent'>" . htmlentities($postData[0]['postcontent']) . "</div>";
$output .= "<a href='/blog/comment/show/" . $postId . "'>Comment this</a>";
$output .= "<div class='commentsHolder'>";
$output .= "<h3>Comments:</h3>";
foreach ($postComments as $comment) {
	$output .= "<div class='comment'>";
	$output .= "<span>On " . date('d.m.Y - H:i', $comment['dateadded']) . "</span>";
	$output .= " - from: ";
	$output .= "<span>" . htmlentities($comment['name']) . "</span>";
	$output .= " - email: ";
	$output .= "<span>" . htmlentities($comment['email']) . "</span>";
	$output .= "<div class='commentContent'>" . htmlentities($comment['comment']) . "</div>";
	if (isset($_SESSION['admin'])) {
		$output .= "<a href='/blog/comment/delete/" . $comment['id'] . "'>[X]</a>";
	}
	$output .= "</div>";
}
$output .= "</div>";
$output .= "<div>";

echo $output;