</br>
</br>
</br>
</br>
<?php

	include'navbar.php';	
	if($user->isLoggedIn() && !empty($_SESSION['cart'])){

			if(isset($_POST)){

			if(token::check(input::get('token'))){

				$validate = new Validate();
				$validation = $validate->check($_POST, array(

					'name' => array(
						'required' => true,
						'min' => 2,
						'max' => 50
						),
					'address' => array(
						'required' => true,
						'min' => 3
						),
					'pincode' => array(
						'required' => true,
						'min' => 6,
						'max' => 6
						),
					'phone_no' => array(
						'required' => true,
						'min' => 6
						)

					));

				$validate_order = new validateorder();
				$validate_order->validate($_POST['name'], $_POST['phone_no'], $_POST['pincode'], $_POST['city'], $_POST['state']);

				if($validation->passed() && $validate_order->passed()){

					$userop->place_order($_SESSION['user'], $_POST['name'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['pincode'], $_POST['phone_no'],$cart->total_price());
					if(!$userop->error()){
						
						$order_des = $db->get('orders', array('userid', '=', $_SESSION['user']))->assocresults();

						if(!$db->error()){

							echo $userop->message();
							$count4 = $db->count();
							$orderid = $order_des[$count4-1]['orderid'];

						}

						foreach($_SESSION['cart'] as $item_des){
						
							$userop->place_order_descrip($orderid, $item_des['itemid'], $_SESSION['user'], $item_des['catagory'], $item_des['qty']);
						
						}

						unset($_SESSION['cart']);
						redirect::to('payment.php');

					}

				}else{

					foreach ($validation->errors() as $error) {
						echo $error, "</br>";
					}
					foreach($validate_order->errors() as $error){
						echo $error,"</br>";
					}

				}

			}

		}

		?>
		<form action="" method="post">
			<label for="name">Name: </label>
			<input type="text" name="name" id="name" value="">
			</br>
			<label for="address">Address: </label>
			<input type="text" name="address" id="address" value="">
			</br>
			<p><b>City: </b></p>
			<select id="city" name="city">
				<option>Delhi</option>
				<option>Noida</option>
				<option>Gurgaon</option>
				<option>Faridabad</option>
			</select>
			</br>
			<p><b>State: </b></p>
			<select id="state" name="state">
				<option>New Delhi</option>
				<option>NCR</option>
			</select>
			</br>
			<label for="pincode">Pincode: </label>
			<input type="text" name="pincode" id="pincode" value="">
			</br>
			<label for="phone_no">Contact No.: </label>
			<input type="text" name="phone_no" id="phone_no" value="">
			<input type="hidden" name="token" id="token" value="<?php echo token::generate();?>">
			</br>
			<input type="submit" class="btn btn-lg btn-primary btn-default" value="Proceed to pay">
			<input type="reset" class="btn btn-default btn-lg">
		</form>
		<?php

	}else{

		echo "Your cart is empty";

	}

?>
</body>
</html>