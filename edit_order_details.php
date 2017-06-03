<?php

	include'navbar.php';
	$orderid = $_POST['orderid'];
	$orders = $db->get('orders', array('orderid', '=', $orderid))->assocresults();
	$order = $orders[0];

	if(!empty($_POST)){

		if(isset($_POST['save_changes'])){

			$arr = array(
				'name' => escape($_POST['name']),
				'address' => escape($_POST['address']),
				'city' => escape($_POST['city']),
				'state' => escape($_POST['state']),
				'pincode' => escape($_POST['pincode']),
				'phone_no' => escape($_POST['phone_no'])
				);
			$db->update('orders', $arr, array('orderid', '=', $orderid));
			if(!$db->error()){

				?>
				</br>
				</br>
				</br>
				</br>
				<p>Your changes have saved sucessfully.</p>
				<p><b><a href="index.php">Continue Shopping</a></b></p>
				<?php

			}

		}

	}

	if($_SESSION['user'] == $order['userid']){

	?>
	</br>
	</br>
	</br>
	</br>
	<form action="" method="post">
		<lable for="name">Name: </lable>
		<input type="text" name="name" id="name" value="<?php echo escape($order['name']);?>">
		<lable for="address">Address: </lable>
		<input type="text" name="address" id="address" value="<?php echo escape($order['address']);?>">
		<lable for="city">City: </lable>
		<input type="text" name="city" id="city" value="<?php echo escape($order['city']);?>">
		<lable for="state">State: </lable>
		<input type="text" name="state" id="state" value="<?php echo escape($order['state']);?>">
		<lable for="pincode">Pin: </lable>
		<input type="text" name="pincode" id="pincode" value="<?php echo escape($order['pincode']);?>">
		<lable for="phone_no">Contact No.: </lable>
		<input type="text" name="phone_no" id="phone_no" value="<?php echo escape($order['phone_no']);?>">
		<input type="hidden" name="save_changes" id="save_changes" value="save_changes">
		<input type="hidden" name="orderid" id="orderid" value="<?php echo $orderid;?>">
		<input type="submit" name="save" id="save" value="Save">
	</form>
	<?php		

	}

?>
</home>
</html>