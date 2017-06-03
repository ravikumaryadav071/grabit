<?php
require_once '../user_login/core/init.php';

$user = new user();
$userop = new usersop();
$itemid = $_GET['itemid'];
$catagory_table = $_GET['catagory_table'];
$userid = $_GET['userid'];
$action = $_GET['action'];
if($user->isLoggedIn()){

	if($_SESSION['user'] == $userid){

		switch ($action) {

			case 'add':
					$userop->add_to_wishlist($userid, $itemid,$catagory_table);
					echo $userop->message();	
				break;

			case 'delete':
					$userop->delete_from_wishlist($userid, $itemid);
					echo $userop->message();
				break;

		}
	}
}
?>