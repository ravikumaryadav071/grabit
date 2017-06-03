<?php

require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';

$user = new user();
$count1 = NULL;
$count2 = NULL;
if($user->isLoggedIn()){

	if($user->hasPermission('admin')){

		$db = DBstore::getstoreInstance();
		$userop = new usersop();
		$admin = new admin();
		$orders = $db->query('SELECT * FROM orders',array(),'SELECT *')->assocresults();
		$count1 = $db->count();

		if(!empty($_POST)){

			if($_POST['table_name'] == 'orders'){

				if(isset($_POST['edit'])){

					$result = $orders[$_POST['result_no']];
					foreach($result as $key=>$value){
						
						if($key != 'orderid'){

							$arr[$key] = $_POST[$key];
						}

					}

					$db->update($_POST['table_name'], $arr, array('orderid', '=', $result['orderid']));
					if(!$db->error()){

						echo "Details of orderid : {$result['orderid']} has updated.";

					}
			}

				if(isset($_POST['cancel'])){

					$result = $orders[$_POST['result_no']];
					$userop->cancel_order($result['orderid']);

					if(!$userop->error()){

						echo 'Orderid: '.$result['orderid'];
						echo '</br>';
						echo $userop->message();

					}

				}

			}

			if(isset($_POST['table_name']) == 'orders_descrip'){

				if(isset($_POST['edit'])){

					$order_descrip = $admin->get_order_details('orders_descrip', array('orderid' => $_POST['orderid']))->assocresults();
					$result = $order_descrip[$_POST['result_no']];
					$arr = array();
					$str = '';
					$where = '';
					$x = 1;
					$y = 1;
					foreach($result as $key=>$value){

						if(!in_array($key, array('orderid', 'userid', 'itemid'))){

							$arr[$key] = $_POST[$key];
							if($x == 1){

								$str .= $key.' = ? ';  

							}else{

								$str .= ', '.$key.'= ? ';

							}

							$x = $x + 1;
						}

						else{
							if($y == 1){

								$where .= $key.' = '.$_POST[$key]; 

							}
							else{

								$where .= ' AND '.$key.' = '.$_POST[$key];

							}

							$y = $y+1;
						}

					}

					$db->query("UPDATE {$_POST['table_name']} SET {$str} WHERE {$where}", $arr, 'UPDATE');

					if(!$db->error()){

						$item_no = $_POST['result_no']+1;
						echo "Details of Item number: {$item_no} having Orderid: {$_POST['orderid']} has updated.";

					}

				}

			}

		}

		$orders = $db->query('SELECT * FROM orders',array(),'SELECT *')->assocresults();
		$count1 = $db->count();

		for($i=0; $i<$count1; $i++){
			$result1 = $orders[$i];
?>

<fieldset><legend><?php echo 'Orderid '.$result1['orderid']; ?></legend>
	<form action="" method="post">
		<?php foreach($result1 as $key1=>$value1){?>
		<lable for="<?php echo $key1;?>"><?php echo $key1;?></lable>
		<input type="text" name="<?php echo $key1;?>" id="<?php echo $key1;?>" value="<?php echo $value1;?>" <?php if($key1 == 'orderid'){ ?> disabled="disabled" <?php } ?>>

<?php
}
?>
	<input type="hidden" name="result_no" id="result_no" value="<?php echo $i; ?>">
	<input type="hidden" name="table_name" id="table_name" value="orders">
	<input type="submit" name="edit" id="edit" value="Edit">
	<input type="submit" name="cancel" id="cancel" value="Cancel">
	</form>
	<fieldset><legend><?php echo 'Orderid '.$result1['orderid'].' Description'; ?></legend>

<?php

			$order_descrip = $admin->get_order_details('orders_descrip', array('orderid' => $result1['orderid']))->assocresults();
			$count2 = $admin->count();
			for($j=0; $j<$count2; $j++){
				$result2 = $order_descrip[$j];

?>

<fieldset><legend><?php echo 'Item '.($j+1); ?></legend>
<form action="" method="post">

<?php
				foreach($result2 as $key2=>$value2){
					$result3 = $db->query("SELECT * FROM {$result2['catagory']} WHERE itemid = ?", array($result2['itemid']), 'SELECT *')->first();
					if(in_array($key2, array('orderid', 'userid', 'itemid', 'catagory'))){
						switch($key2){


							case 'orderid':
?>

<p>NAME : <?php echo $result3->name; ?> | 
	ITEM ID : <?php echo $result3->itemid; ?> | 
	<input type="hidden" name="<?php echo $key2;?>" id="<?php echo $key2;?>" value="<?php echo $value2;?>">

<?php

							break;
							case 'userid':

?>

COLOR : <?php echo $result3->color; ?> | 
<input type="hidden" name="<?php echo $key2;?>" id="<?php echo $key2;?>" value="<?php echo $value2;?>">

<?php

							break;
							case 'itemid':

?>

PRICE : <?php echo $result3->price; ?> | 
<input type="hidden" name="<?php echo $key2;?>" id="<?php echo $key2;?>" value="<?php echo $value2;?>">

<?php

							break;

						case 'catagory':
?>
CATAGORY : <?php echo $result2['catagory']; ?></p>
<input type="hidden" name="<?php echo $key2;?>" id="<?php echo $key2;?>" value="<?php echo $value2;?>">

<?php
						break;
					}
				}else{

?>

	<lable for="<?php echo $key2;?>"><?php echo $key2;?></lable>
	<input type="text" name="<?php echo $key2;?>" id="<?php echo $key2;?>" value="<?php echo $value2;?>">

<?php

		}
	}

?>
	<input type="hidden" name="result_no" id="result_no" value="<?php echo $j; ?>">
	<input type="hidden" name="table_name" id="table_name" value="orders_descrip">
	<input type="submit" name="edit" id="edit" value="Edit">
</form>
</fieldset>

<?php

	}

?>

</fieldset>
<p>TOTAL PRICE : <?php ?> | TOTAL ITEMS : <?php ?></p>
</fieldset>

<?php
}
?>
<?php
}
}else{
	echo '<p>You need to <a href="login.php">login</a></p>';
}

?>

<p>Go to <a href="index.php">home</a> page.</p>