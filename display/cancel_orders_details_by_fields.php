<?php

require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';

$user = new user();
$count1 = NULL;
$count2 = NULL;
$db = DBstore::getstoreInstance();
$userop = new usersop();
$admin = new admin();
$arr = array();

if($user->isLoggedIn()){

	if($user->hasPermission('admin')){


		$fields = $db->query("SELECT * FROM cancel_orders", array(), 'SELECT *')->assocresults();
		$result = $fields[0];

		if(!empty($_POST)){

			if(isset($_POST['search']) && ($_POST['table_name'] == 'cancel_orders')){

				if(isset($_POST['key']) && isset($_POST['value'])){

					$arr[$_POST['key']] = $_POST['value'];

				}else{

					foreach ($result as $key => $value) {
						
						if(isset($_POST[$key])){

							$arr[$key] = $_POST[$key];

						}
					}
				}

				if(isset($arr['date'])){

					$orders = $db->query("SELECT * FROM {$_POST['table_name']} WHERE date LIKE '%{$arr['date']}%'", array(), 'SELECT *')->assocresults();
					$count1 = $db->count();

				}else{

					$orders = $admin->get_order_details($_POST['table_name'], $arr)->assocresults();
					$count1 = $admin->count();
					
				}

				if(isset($_POST['from'])){

					if($_POST['from'] == 'cancel_orders'){

						if(isset($_POST['edit'])){

							$res = $orders[$_POST['result_no']];

							foreach($res as $key=>$value){
								
								if(!in_array($key, array('orderid', 'userid', 'amount'))){

									$arr1[$key] = $_POST[$key];
								}

							}

							$db->update($_POST['from'], $arr1, array('orderid', '=', $res['orderid']));

							if(!$db->error()){

								echo "Details of orderid : {$res['orderid']} has updated.";

							}

						}

					}
				}

				if(isset($arr['date'])){

					$orders = $db->query("SELECT * FROM {$_POST['table_name']} WHERE date LIKE '%{$arr['date']}%'", array(), 'SELECT *')->assocresults();
					$count1 = $db->count();

				}else{

					$orders = $admin->get_order_details($_POST['table_name'], $arr)->assocresults();
					$count1 = $admin->count();

				}

				?>
				<p>Total <?php echo $count1; ?> search results.</p> 
				<?php

				for($i=0; $i < $count1; $i++){

					$result1 = $orders[$i];
					$x = $i+1;

					?>

					<fieldset><legend>Result No. : <?php echo $x; ?> | Orderid : <?php echo $result1['orderid']?></legend>
					<form action="" method="post">
					<?php

					foreach($result1 as $key=>$value){

						?>
						<lable for="<?php echo $key; ?>"><?php echo $key; ?></lable>
						<input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>" <?php if(($key=='orderid')||($key=='userid')){?> disabled="disabled" <?php } ?>>
						<?php

					}

					?>
					<input type="hidden" name="search" id="search" value="Search">
					<input type="hidden" name="table_name" id="table_name" value="cancel_orders">
					<input type="hidden" name="key" id="key" value="<?php foreach($arr as $key=>$value){ echo $key; }?>">
					<input type="hidden" name="value" id="value" value="<?php foreach($arr as $key=>$value){ echo $value; }?>">
					<input type="hidden" name="result_no" id="result_no" value="<?php echo $i; ?>">
					<input type="hidden" name="from" id="from" value="cancel_orders">
					<input type="submit" name="edit" id="edit" value="Edit">
					</form>
					<?php

					foreach($result1 as $key=>$value){

						if(in_array($key,array('orderid', 'userid', 'itemid'))){

							$arr2[$key] = $result1[$key];

							}

						}


					$orders_descrip = $admin->get_order_details('cancel_orders_descrip', $arr2)->assocresults();
					$count2 = $admin->count();

					for($j=0; $j<$count2; $j++){

						$result2 = $orders_descrip[$j];
						$item_detail = $db->get($result2['catagory'],array('itemid', '=', $result2['itemid']))->assocresults();
						$result3 = $item_detail[0];
						$y = $j+1;
						?>

						<fieldset><legend>Item No. : <?php echo $y;?> | <?php echo $result3['name'];?></legend>
							<form action="" method="post">

						<?php
						foreach($result2 as $key=>$value){

							if(in_array($key, array('orderid', 'userid', 'itemid', 'catagory'))){

								switch ($key) {
									case 'orderid':
										?>
										<p> NAME : <?php echo $result3['name'];?> | 
											ITEM ID : <?php echo $result3['itemid'];?> | 
										<input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>">
										<?php
										break;
									
									case 'userid':
										?>
										COLOR : <?php echo $result3['color'];?> | 
										<input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>">
										<?php
										break;

									case 'itemid':
										?>
										PRICE : <?php echo $result3['price'];?> | 
										<input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>">
										<?php
										break;

									case 'catagory':
										?>
										CATAGORY : <?php echo $result2['catagory']?> | 
										<input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>">
										<?php
										break;
								}

							}else{

								?>

								<lable for="<?php echo $key;?>"><?php echo $key;?></lable>
								<input type="text" name="<?php echo $key;?>" id="<?php echo $key;?>" value="<?php echo $value;?>">
								<input type="submit" name="edit_item" id="edit_item" value="Edit">

								<?php
							}

						}
						?>
						<input type="hidden" name="search" id="search" value="Search">
						<input type="hidden" name="table_name" id="table_name" value="cancel_orders">
						<input type="hidden" name="key" id="key" value="<?php foreach($arr as $key=>$value){ echo $key; }?>">
						<input type="hidden" name="value" id="value" value="<?php foreach($arr as $key=>$value){ echo $value; }?>">
						<input type="hidden" name="result_no" id="result_no" value="<?php echo $j; ?>">
						<input type="hidden" name="from" id="from" value="cancel_orders_descrip">
						</form>
						</fieldset>
						<?php
					}
					?>
					<p> TOTAL AMOUNT: <?php echo $result1['amount'];?> </p>
				</fieldset>
				<?php
				} 

			}

		}

		?>

		<fieldset><legend>Search Cancelled Orders By Field</legend>
		<?php
		foreach($result as $key=>$value){

			?>

			<form action="" method="post">
				<lable for="<?php echo $key;?>"><?php echo $key;?></lable>
				<input type="text" name="<?php echo $key;?>" id="<?php echo $key;?>">
				<input type="hidden" name="table_name" id="table_name" value="cancel_orders">
				<input type="submit" name="search" id="search" value="Search">
			</form>

			<?php

		}

		?>
		</fieldset>
		<?php

	}
}else{
	echo '<p>You need to <a href="login.php">login</a></p>';
}

?>

<p>Go to <a href="index.php">home</a> page.</p>