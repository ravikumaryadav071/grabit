</br>
</br>
</br>
<p><b>Your Wishlist</b></p>
<?php
	include('navbar.php');
	if($user->isLoggedIn()&& ($_SESSION['user']!=100)){

		$items = $db->query('SELECT * FROM wishlist WHERE userid = ?', array($_SESSION['user']), 'SELECT *')->assocresults();
		$count1 = $db->count();

		if($count1>0){

			for($i=$count1-1; $i>=0; $i--){

				$item = $items[$i];
				$catagory_table = $item['catagory'];
				$itemid = $item['itemid'];
				$item_descrip = $db->get($catagory_table, array('itemid', '=', $itemid))->first();
				?>

				<div style="border-bottom: 1px solid black" id="<?php echo"container{$i}"?>">
					<div id="delete_response<?php echo"{$i}"?>"></div>
					<img src="<?php echo $item_descrip->image;?>" class="img-responsive" style="float: left">
					<h3><?php echo $item_descrip->name;?></h3>
					<small><?php echo $item_descrip->color;?></small>
					</br>
					<small>by <?php echo $item_descrip->brand;?></small>
					<h4>PRICE: <?php echo $item_descrip->price;?></h4>
					<small style="font-color: red"><b><?php if($userop->check_stock($itemid, $catagory_table)->error()){?>Out of stock.<?php } ?></b></small>
					<span id="response_text<?php echo $i;?>"></span>
					<button type="button" name="delete_from_wishlist<?php echo $i;?>" id="delete_from_wishlist<?php echo $i;?>" class="btn btn-default btn-lg" onCLick="delete_from_wishlist(<?php echo"{$i}, '{$catagory_table}', {$itemid}, {$_SESSION['user']}"; ?> );"><span class="glyphicon glyphicon-trash"></span></button>
					<button type="button" name="add_to_cart<?php echo $i;?>" id="add_to_cart<?php echo $i;?>" class="btn btn-default btn-lg" onClick="added(<?php echo "{$i}, '{$catagory_table}', {$itemid}, {$_SESSION['user']}";?>);" <?php if(isset($_SESSION['cart'][$itemid]) || ($userop->check_stock($itemid, $catagory_table)->error())){?>disabled="disabled" <?php } ?>><span class="glyphicon glyphicon-shopping-cart"></span></button>
				</div>
				<?php

			}
		}

		?>
		<script type="text/javascript" src="javascripts/delete_from_wishlist.js"></script>
		<?php

	}else{
		?><a href="login.php">Login</a> first.
		<?php
	}
?>
</head>
</html>