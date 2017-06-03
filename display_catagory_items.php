<?php
	include('navbar.php');
?>
</br>
</br>
</br>

<?php

	$catagory = $db->get('catagory_list',array('catagory_id', '=', $_GET['catagory_id']))->assocresults();
	$catagory = $catagory[0];
	$catagory_table = $catagory['catagory_table'];
	$items = $db->query("SELECT * FROM {$catagory_table}", array(), 'SELECT *')->results();
	$count = $db->count();
	static $guest = false;
	if(isset($_SESSION['user'])){

		if($_SESSION['user'] == 100){

			$guest = true;

		}

	}
	?>
	<div class="row" id="item-container">
		<?php
		for($i=0; $i<$count; $i++){

			$item = $items[$i];
			$itemid = $item->itemid;
			?>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
				<div class="thumbnail">
					<a href="display_item.php?itemid=<?php echo $item->itemid;?>&&catagory=<?php echo $catagory_table;?>">
						<img src="<?php echo $item->image;?>" alt="<?php echo $item->name;?>" id="display-item" class="img-responsive"/>	
						<div class="caption">
							<h4><?php if(strlen($item->name) <= 18){echo substr($item->name, 0, 18);}else{echo substr($item->name, 0, 18)."...";}?></h4>
					</a>
						<small><?php echo $item->color;?></small></br>
						<small>by <?php echo $item->brand;?></small></br>
						<h4>Price: <?php echo $item->price;?> <small style="font-color: red"><b><?php if($userop->check_stock($itemid, $catagory_table)->error()){?>Out of stock.<?php } ?></b></small></h4>
						<span id="response_text<?php echo $i;?>"></span>
						<button type="button" class="btn btn-default btn-lg" name="add_to_cart<?php echo $i;?>" id="add_to_cart<?php echo $i;?>" value="ADD TO CART" onClick="added(<?php echo "{$i}, '{$catagory_table}', {$itemid}, {$_SESSION['user']}";?>);" <?php if(isset($_SESSION['cart'][$itemid]) || ($userop->check_stock($itemid, $catagory_table)->error())){ ?>disabled="disabled" <?php } ?>><span class="glyphicon glyphicon-shopping-cart"></span></button> 
						<input type="button" class="btn btn-default btn-lg" name="add_to_wishlist<?php echo $i;?>" id="add_to_wishlist<?php echo $i;?>" value="Add to Wishlist" onClick="added_to_wishlist(<?php echo "{$i}, '{$catagory_table}', {$itemid}, {$_SESSION['user']}";?>);" 
						<?php  
							if($user->isLoggedIn() || $guest){ 
								if($db->query("SELECT * FROM wishlist WHERE userid = ? AND itemid = ?", array($_SESSION['user'], $itemid), 'SELECT *')->count() != 0 || $guest){
									?>
									disabled="disabled" 
									<?php  
								} 
							} 
						?>
						>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</body>
</html>