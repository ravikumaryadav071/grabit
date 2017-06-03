</br>
</br>
</br>
<?php

	include('navbar.php');
	
	if($user->isLoggedIn()&& ($_SESSION['user']!=100)){

		$orders = $db->get('orders', array('userid', '=', $_SESSION['user']))->assocresults();
		$count1 = $db->count();
		
		for($i=$count1-1; $i>=0; $i--){

			?>
			<div id="order_no<?php echo $i;?>">
			<span id="response_text<?php echo $i;?>"></span>
			<fieldset> <!-- style="border: 1px solid black" -->
			<?php
			$order = $orders[$i];
			$orderid = $order['orderid'];
			$order_descriptions = $db->get('orders_descrip', array('orderid','=',$orderid))->assocresults();
			$count2 = $db->count();
			?>

			<h4><b><?php echo $order['name']; ?></b></h4>
			<p>
				Orderid: <?php echo $orderid; ?></br>
				Address: <?php echo $order['address'].' '.$order['city'].' '.$order['state'];?></br>
				Pin: <?php echo $order['pincode'];?></br>
				Contact No. : <?php echo $order['phone_no'];?></br>
				<b>Total Amount: <?php echo $order['amount'];?></b>
			</p>
			<?php
			for($j=0; $j<$count2; $j++){

				?>
				<div>
				<fieldset>
				<?php
				$order_descrip = $order_descriptions[$j];
				$item_detail = $db->get($order_descrip['catagory'], array('itemid', '=', $order_descrip['itemid']))->first();
				?>
				<a href="display_item.php?catagory=<?php echo $order_descrip['catagory'];?>&&itemid=<?php echo $order_descrip['itemid'];?>">
					<img src="<?php echo $item_detail->image;?>" style="flaot: left" class="img-responsive">
					<h4><?php echo $item_detail->name;?></h4>
				</a>
				<small>
					<?php echo $item_detail->color;?></br>
					by <?php echo $item_detail->brand;?>
				</small>
				<h5><b>Price: <?php echo $item_detail->price;?></b></h5>
				</fieldset>
				</div>
				<?php
			}

			?>
			<?php
			if($order['delivered'] == 'NO'){
			?>
				<button name="cancel_order<?php echo $i;?>" id="cancel_order<?php echo $i;?>" class="btn btn-primary btn-lg btn-block" onClick="cancel_order(<?php echo "{$i}, {$orderid}"; ?>);">Cancel Order</button>
				<form action="edit_order_details.php" method="post">
					<input type="hidden" name="orderid" id="orderid" value="<?php echo $orderid; ?>">
					<button type="submit" name="edit_details<?php echo $i;?>" id="edit_details<?php echo $i;?>" class="btn btn-default btn-lg btn-block">Edit Details</button>
				</form>
			<?php
			}
			?>
			</fieldset>
			</div>
			<?php
		}

	}else{

		?>
		You need to <a href="login.php">Login.</a>.
		<?php

	}

?>
<script type="text/javascript" src="javascripts/cancel_order.js"></script>
</body>
</html>