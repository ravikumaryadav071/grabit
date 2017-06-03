<?php

require_once 'user_login/core/init.php';

$user = new user();
$count1 = NULL;
$count2 = NULL;
if($user->isLoggedIn()){

	if($user->hasPermission('admin')){

		$db = DBstore::getstoreInstance();
		$userop = new usersop();
		$admin = new admin();
		$cancel_orders = $db->query('SELECT * FROM cancel_orders',array(),'SELECT *')->assocresults();
		$count1 = $db->count();

		for($i=0; $i<$count1; $i++){
			$result1 = $cancel_orders[$i];
?>

<fieldset><legend><?php echo 'Orderid '.$result1['orderid']; ?></legend>
	<form action="" method="post">
		<?php foreach($result1 as $key1=>$value1){?>
		<lable for="<?php echo $key1;?>"><?php echo $key1;?></lable>
		<input type="text" name="<?php echo $key1;?>" id="<?php echo $key1;?>" value="<?php echo $value1;?>" <?php if($key1 == 'orderid'){ ?> disabled="disabled" <?php } ?>>

<?php
}
?>
	</form>
	<fieldset><legend><?php echo 'Orderid '.$result1['orderid'].' Description'; ?></legend>

<?php

			$cancel_order_descrip = $admin->get_order_details('cancel_orders_descrip', array('orderid' => $result1['orderid']))->assocresults();
			$count2 = $admin->count();
			for($j=0; $j<$count2; $j++){
				$result2 = $cancel_order_descrip[$j];

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

<?php

							break;
							case 'userid':

?>

COLOR : <?php echo $result3->color; ?> | 

<?php

							break;
							case 'itemid':

?>

PRICE : <?php echo $result3->price; ?> |

<?php

							break;
							case 'catagory':
?>

CATAGORY : <?php echo $result2['catagory']; ?> |

<?php

						}
					}else{

?>

	<lable for="<?php echo $key2;?>"><?php echo $key2;?></lable>
	<input type="text" name="<?php echo $key2;?>" id="<?php echo $key2;?>" value="<?php echo $value2;?>">

<?php

		}
	}

?>
</form>
</fieldset>

<?php

	}

?>

</fieldset>
<p>TOTAL PRICE : <?php $result1['amount']?></p>
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