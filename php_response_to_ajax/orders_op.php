<?php

	require_once '../user_login/core/init.php';

	$user = new user();
	$db = DBstore::getstoreInstance();
	$orderid = $_GET['orderid'];
	$action = $_GET['action'];
	$userop = new usersop();
	if($user->isLoggedIn()){

		switch ($action) {

			case 'add':

				$user_des = $db->get('orders', array('orderid', '=', $orderid))->first();
				$userid = $user_des->userid;
				
				if($_SESSION['user'] == $userid){

					

				}

				break;
			
			case 'delete':
				
				$user_des = $db->get('orders', array('orderid', '=', $orderid))->first();
				$userid = $user_des->userid;
				
				if($_SESSION['user'] == $userid){

					$userop->cancel_order($orderid);
					if(!$userop->error()){

						echo $userop->message();

					}

				}

				break;
		}

	}
?>