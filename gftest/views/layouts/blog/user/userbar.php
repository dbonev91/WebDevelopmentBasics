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
}
else {
	$userbar = "<div class='userbar'>";
	$userbar .= "<a href='/blog/login/show'>Login</a>";
	$userbar .= "<a href='/blog/registration/reg'>Register</a>";
}

if (isset($_SESSION['error'])) {
	$userbar .= "<div class='error' style='background: red'>" . $_SESSION['error'] . "</div>";
	unset($_SESSION['error']);
}
else if (isset($_SESSION['success'])) {
	$userbar .= "<div class='success' style='background: green'>" . $_SESSION['success'] . "</div>";
	unset($_SESSION['success']);
}

$userbar .= "<form class='searchForm' method='post'>";
$userbar .= "<input type='text' name='search' class='search' id='search' />";
$userbar .= "<input type='submit' name='submit' class='submit' id='submit' value='Search posts' />";
$userbar .= "</form>";
$userbar .= "</div>";

echo $userbar;