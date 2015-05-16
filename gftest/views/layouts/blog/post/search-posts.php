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
$output = "<h2>Results for: " . htmlentities($this->input->get(0)) . "</h2>";

echo $output;

include_once 'gftest/models/PostOut.php';

foreach ($search as $results) {
	foreach ($results as $result) {
		$posts = $this->db->prepare("SELECT title, dateadded, visitscount, id FROM blog_posts WHERE id=?")->
			execute(array($result['post_id']))->fetchAllAssoc();
			
		foreach ($posts as $post) {
			$postOut = new \Models\PostOut($post['id'], $post['title'], $post['dateadded'], $post['visitscount']);
			
			echo $postOut->drawElement();
		}
	}
}