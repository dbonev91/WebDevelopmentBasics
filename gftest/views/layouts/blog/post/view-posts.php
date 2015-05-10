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

foreach ($posts->fetchAllAssoc() as $post) {
	$output .= "<div class='postBody allPosts'>";
	$output .= "<div class='title'><a href='/blog/post/view/{$post['id']}'>" . htmlentities($post['title']) . "</a></div>";
	$output .= "<div class='dateadded'>Добавен на: " . date('d.m.Y', htmlentities($post['dateadded'])) . "</div>";
	$output .= "<div class='visits'>{$post['visitscount']} преглеждания</div>";
	
	if (isset($_SESSION['admin'])) {
		$output .= "<a href='/blog/post/delete/" . $post['id'] . "'>[X]</a>";
	}
	$output .= "</div>";
}

$allPosts = $this->db->prepare("SELECT COUNT(title) AS count FROM blog_posts")->execute()->fetchAllAssoc();
$postsCount = $allPosts[0]['count'];
$allPages = intval($postsCount / $postsByPage);

$output .= "<br /><br />";

// Paging
$output .= "<div class='pages'>";

// First page
if ($currentPage != 1) {
	$output .= "<a href='/blog/post/all/" . 1 . "'>First</a> | ";
}
else {
	$output .= 'First |';
}

// Previeous page
if ($prevPage != null && $prevPage > 0) {
	$output .= "<a href='/blog/post/all/" . $prevPage . "'>Prev</a> | ";
}
else {
	$output .= "Prev | ";
}

// All avaiable pages
for ($page = 1; $page <= ($allPages + 1); $page++) {
	if ($page == $currentPage) {
		$output .= $page;
	}
	else {
		$output .= "<a href='/blog/post/all/" . $page . "'>" . $page . "</a>";
	}
	if ($page <= $allPages) {
		$output .= " | ";
	}
}

// Next page
if ($nextPage != null && $nextPage <= ($allPages + 1)) {
	$output .= " | <a href='/blog/post/all/" . $nextPage . "'>Next</a>";
}
else {
	$output .= " | Next";
}

// Last page
if ($currentPage != ($allPages + 1)) {
	$output .= " | <a href='/blog/post/all/" . ($allPages + 1) . "'>Last</a>";
}
else {
	$output .= " | Last";
}

$output .= "</div>";

echo $output;