</br>
</br>
</br>
</br>
<?php

include 'navbar.php';

if($user->isLoggedIn()){

	$item = $db->get($_GET['catagory'], array('itemid', '=', $_GET['itemid']))->assocresults();
	$item_details = $item[0];

		?>
		<div align="center">
			<img src="<?php echo $item_details['image'];?>" alt="<?php echo $item_details['name'];?>" class="img-responsive">
			<div>
				<h1><?php echo $item_details['name'];?></h1>
				<b><?php echo $item_details['color'];?></b></br>
				<b>by <?php echo $item_details['brand'];?></b>
				<h2>Price: <?php echo $item_details['price'];?></h2>
				<span id="add_to_cart_text"></span>
				<input type="button" name="add_to_cart" id="add_to_cart" value="ADD TO CART"> 
			</div>
		</div>
		<?php

?>

<?php
}
?>
</body>
</html>