<?php

require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';

$user = new user();
if($user->isLoggedIn()){

	if($user->hasPermission('admin')){

		$db = DBstore::getstoreInstance();
		$admin = new admin();
		$userop = new usersop();
		$fields = $db->query("SELECT * FROM orders", array(), 'SELECT *')->assocresults();
		$result = $fields[0];

		if(!empty($_POST)){

			if(isset($_POST['search'])){

				foreach($result as $key=>$value){

					if(isset($_POST[$key])){

						$arr[$key] = $_POST[$key];

					}

				}

				$bills = $admin->get_order_details('orders', $arr)->assocresults();
				$count1 = $admin->count();

				for($i=0; $i<$count1; $i++){

					$x = $i+1;

					?>
					<form action="" method="post">
						<input type="hidden" name="orderid" id="orderid" value="<?php echo $bills[$i]['orderid'];?>">
						<input type="submit" name="get_bill" id="get_bill" value="<?php echo 'Bill No.'.$x;?>">
					</form>
					<?php

				}

			}


			if(isset($_POST['get_bill'])){

				$orderid = $_POST['orderid'];
				$res = $admin->get_order_details('orders', array('orderid'=>$orderid))->assocresults();
				$details = $res[0];
				$arr1['orderid'] = $orderid;
				$order_descrip = $admin->get_order_details('orders_descrip', $arr1)->assocresults();
				$count2 = $admin->count();

				?>
				<span align="">
				<table>
					<tr>
				<?php
				
				foreach($details as $key=>$value){

					switch($key){
						
						case 'orderid':

						?>
						Orderid : <?php echo $value;?>
						</tr>
						<?php
							
						break;

						case 'name':
							
						?>
						
						<tr align="center">
							Name : <?php echo $value;?>
						</tr>
						<?php

						break;

						case 'address':
							
						?>
						<tr align="center"><td>
							Address : <?php echo $value;?>
						</td>
						<?php

						break;

						case 'city':

						?>
						<td>
							<?php echo $value;?>
						</td>
						<?php
							
						break;

						case 'state':

						?>
						<td>
							<?php echo $value;?>
						</td>
						<?php
							
						break;

						case 'pincode':

						?>
						<td>
							  Pincode : <?php echo $value;?>
						</td></tr>
						<?php
							
						break;

						case 'phone_no':

						?>
						<tr align="center">
							Phone No. : <?php echo $value;?>
						</tr>
						<?php
							
						break;

						case 'date':

						?>
						<tr align="center">
							Date : <?php echo $value;?>
						</tr>
						<?php
							
						break;
					}

				}
				?>
				<tr>
			<table><caption>Order Details</caption>
				<th width="20%">Itemid</th>
				<th width="20%">Item Name</th>
				<th width="20%">Catagory</th>
				<th width="20%">Price</th>
				<th width="20%">Quantity</th>
				<?php

				for($i=0; $i<$count2; $i++){

					?>
					<tr align="center">
					<?php
					$result1 = $order_descrip[$i];
					$y = $i+1;
					$arr2 = array('itemid', '=', $result1['itemid']);
					$result2 = $db->get($result1['catagory'], $arr2)->first();

					foreach($result1 as $key1=>$value1){

						switch($key1){

							case 'orderid':

							?>
							<td><?php echo $result2->itemid;?></td>
							<?php

							break;

							case 'userid':
							
							?>
							<td><?php echo $result2->name;?></td>
							<?php

							break;

							case 'itemid':
							
							?>
							<td><?php echo $result1['catagory'];?></td>
							<?php

							break;

							case 'catagory':
							
							?>
							<td><?php echo $result2->price;?></td>
							<?php

							break;

							case 'quantity':
							
							?>
							<td><?php echo $result1['quantity'];?></td>
							<?php

							break;

						}
					
					}

					?>
					</tr>
					<?php

				}

				?>
				</table>
			</tr>
				<?php
				?>
				<tr>
				<p>Total Amount : <?php echo $details['amount'];?></p>
				</tr>
				</table>
			</span>
				<?php

			}

		}


		if(empty($_POST)){
			?>	
			<fieldset><legend>Generate Bill by field</legend>
				<?php
				foreach($result as $key=>$value){
				?>
				<form action="" method="post">
					<lable for="<?php echo $key; ?>"><?php echo $key; ?></lable>
					<input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>">
					<input type="submit" name="search" id="search" value="Search">
				</form>
				<?php
				}
				?>
			</fieldset>
			
			<?php
		}
	}
}else{
	echo '<p>You need to <a href="login.php">login</a></p>';
}
?>