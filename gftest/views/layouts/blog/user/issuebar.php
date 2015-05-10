<?php
$newestPosts = $this->db->prepare(
	"SELECT title, dateadded, id FROM blog_posts 
	ORDER BY dateadded DESC limit 5")->execute()->fetchAllAssoc();
	
$popularestTags = $this->db->prepare(
	"SELECT title 
	FROM blog_tags 
	ORDER BY tagscount DESC limit 5"
)->execute()->fetchAllAssoc();
	
$output = "<section class='popularest'>";
$output .= "<div class='postsHolder' style='display: inline-block; width: 50%'>";
$output .= "<h4>Newest posts:</h4>";

foreach ($newestPosts as $post) {
	$output .= "<div class='newestPosts'>";
	$output .= "<a href='/blog/post/view/" . $post['id'] . "'>" . htmlentities($post['title']) . "</a>";
	$output .= "<span>" . date('d.m.Y - H:i', $post['dateadded']) . "</span>";
	
	if (isset($_SESSION['admin'])) {
		$output .= "<a href='/blog/post/delete/" . $post['id'] . "'>[X]</a>";
	}
	
	$output .= "</div>";
}

$output .= "</div>";
$output .= "<div class='popularestTags' style='display: inline-block; width: 50%; vertical-align: top'>";
$output .= "<h4>Popularest tags:</h4>";

foreach ($popularestTags as $tag) {
	$output .= "<a href='/blog/post/search/" . $tag['title'] . "'>" . htmlentities($tag['title']) . "</a>";
}

$output .= "</div>";
$output .= "</section>";

echo $output;