<?php
	
	require_once '../user_login/core/init.php';
	$user = new user();
	$user_op = new usersop();
	$cart = new cart();
	if($user->isLoggedIn()){

		$itemid = $_GET['itemid'];
		$qty = $_GET['qty'];
		$user_op->check_stock($itemid, $_SESSION['cart'][$itemid]['catagory'], $qty);
		if(!$user_op->error()){		
		
			$cart->edit_qty($itemid, $qty);
			echo $cart->message();

		}else{

			echo $user_op->message();

		}
	
	}

?>