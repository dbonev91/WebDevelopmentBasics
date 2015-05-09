<?php
$db = new \GF\DB\SimpleDB();
$isUserExists = $db->prepare("SELECT username FROM blog_users WHERE username=?")->execute(array($this->userProfile));
if ($isUserExists->getAffectedRows()) {
	$profile = "<h2>{$this->userProfile}'s Prifile</h2>";
	echo $profile;
}
else {
	echo "<h2>There is no user {$this->userProfile}</h2>";
}