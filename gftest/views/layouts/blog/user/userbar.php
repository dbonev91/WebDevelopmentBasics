<?php
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
	if ($_SESSION['user']) {
		$user = $_SESSION['user'];
	}
	else if ($_SESSION['admin']) {
		$user = $_SESSION['admin'];
	}
	
	$userbar = "<div class='userbar'>";
	$userbar .= "<span class='usernameHolder'>{$user}</span>";
	$userbar .= "<span class='logout-button'>[Logout]</span>";
	$userbar .= "</div>";
	
	echo $userbar;
}