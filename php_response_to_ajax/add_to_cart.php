<?php
require_once '../user_login/core/init.php';

$user = new user();
$cart = new cart();
$userop = new usersop();
$itemid = $_GET['itemid'];
$catagory_table = $_GET['catagory_table'];
$userid = $_GET['userid'];
$action = $_GET['action'];
if($user->isLoggedIn()){

	if(!$userop->check_stock($itemid, $catagory_table)->error()){

		switch ($action) {

			case 'add':
					$cart->add_to_cart($itemid, $catagory_table);
					echo $cart->message();	
				break;

			case 'edit':
				
				break;

			case 'delete':
				
				break;

		}
	}else{

		echo $userop->message();

	}
}
?>