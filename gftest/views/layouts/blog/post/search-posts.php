<?php
$tags = explode(' ', htmlentities($this->input->get(0)));
$tag = htmlentities($this->input->get(0));
$search = [];

foreach ($tags as $tag) {
	$currentSearch = $this->db->prepare(
		"SELECT pt.post_id 
		FROM blog_posttags pt 
		JOIN blog_tags t 
		ON t.id=pt.tag_id
		WHERE t.title LIKE ?")->execute(array('%' . $tag . '%'))->fetchAllAssoc();
		
	array_push($search, $currentSearch);
}

// extract results
$output = "<section class='searchedPosts'>";
$output .= "<h2>Results for: " . htmlentities($this->input->get(0)) . "</h2>";

foreach ($search as $results) {
	foreach ($results as $result) {
		$posts = $this->db->prepare("SELECT title, dateadded, visitscount, id FROM blog_posts WHERE id=?")->
			execute(array($result['post_id']))->fetchAllAssoc();
			
		foreach ($posts as $post) {	
			$output .= "<div class='postBody searchPosts'>";
			$output .= "<div class='title'><a href='/blog/post/view/" . $post['id'] . "'>" . htmlentities($post['title']) . "</a></div>";
			$output .= "<div class='dateadded'>Добавен на: " . date('d.m.Y', htmlentities($post['dateadded'])) . "</div>";
			$output .= "<div class='visits'>{$post['visitscount']} преглеждания</div>";
			if (isset($_SESSION['admin'])) {
				$output .= "<a href='/blog/post/delete/" . $post['id'] . "'>[X]</a>";	
			}
			$output .= "</div>";
		}
	}
}

$output .= "</section>";

echo $output;