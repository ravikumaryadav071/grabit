<?php
	
	require_once '../user_login/core/init.php';
	$user = new user();
	if($user->isLoggedIn()){

		$itemid = $_GET['itemid'];
		unset($_SESSION['cart'][$itemid]);
		echo"One Item has removed.";

	}

?>