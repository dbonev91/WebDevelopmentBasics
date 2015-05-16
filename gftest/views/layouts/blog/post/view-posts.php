<?php
$postsByPage = 5;
$currentPage = 1;
if ($this->page) {
	$currentPage = $this->page;
	$nextPage = $this->page + 1;
	$prevPage = $this->page - 1;
	$from = (($this->page - 1) * $postsByPage);
	$limit = $from . ", " . $postsByPage;
}
else {
	$limit = $postsByPage;
	$nextPage = $currentPage + 1;
}
	
$posts = $this->db->prepare(
	"SELECT title, postcontent, dateadded, id, visitscount 
	FROM blog_posts 
	ORDER BY dateadded DESC limit " . $limit)->execute();
	
$output = "<h2>{$this->title}</h2>";

if (isset($_SESSION['sessionToken']) && $this->csrf->checkSessionToken()) {
	$output .= "<a href='/blog/post/form'>Add post</a>";
	$output .= "<br /><br />";
}

echo $output;

include_once 'gftest/models/PostOut.php';

foreach ($posts->fetchAllAssoc() as $post) {
	$outPost = new \Models\PostOut($post['id'], $post['title'], $post['dateadded'], $post['visitscount']);
	echo $outPost->drawElement();
}

$allPosts = $this->db->prepare("SELECT COUNT(title) AS count FROM blog_posts")->execute()->fetchAllAssoc();
$postsCount = $allPosts[0]['count'];
$allPages = intval($postsCount / $postsByPage);

include_once 'gftest/models/PagingModel.php';

$pagingModel = new \Models\PagingModel($currentPage, $allPages, $prevPage, $nextPage);

echo $pagingModel->drawElement();