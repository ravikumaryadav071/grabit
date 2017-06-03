</br>
</br>
</br>
</br>
<b>Search Results</b>
<?php

	include'navbar.php';

	if(isset($_POST['search_text'])){

		$search_text = escape($_POST['search_text']);
		$selected_cats = $db->query("SELECT * FROM catagory_list WHERE catagory_name LIKE '%$search_text%' ", array(), 'SELECT *')->assocresults();
		$count2 = $db->count();
		$total_results = $count2;
		$guest = false;
		
		if(isset($_SESSION['user'])){

			if($_SESSION['user'] == 100){

				$guest = true;

			}

		}

		for($i=0; $i<$count2; $i++){

			$selected_cat = $selected_cats[$i];
			$cat_items = $db->query("SELECT * FROM {$selected_cat['catagory_table']}", array(), 'SELECT *')->results();
			$count3 = $db->count();
			$total_results += $count3;
			$catagory_table = $selected_cat['catagory_table'];

			for($j=0; $j<$count3; $j++){

				$item = $cat_items[$j];
				$itemid = $item->itemid;
				$k = ($i+1).''.$j;
				?>
				<div>
					<a href="display_item.php?catagory=<?php echo $catagory_table; ?>&&itemid=<?php echo $itemid; ?>">
						<img src="<?php echo $item->image;?>"  alt="<?php echo $item->name;?>" class="img-responsive" style="float: left"/>
						<h2><?php echo $item->name;?></h2></a>
						<small><?php echo $item->color;?></small></br>
						<small>by <?php echo $item->brand;?></small>
						<h3>Price: <?php echo $item->price;?></h3>
						<small style="font-color: red"><b><?php if($userop->check_stock($itemid, $catagory_table)->error()){?>Out of stock.<?php } ?></b></small>
						<span id="response_text<?php echo $k;?>"></span>
						<button type="button" class="btn btn-default btn-lg" name="add_to_cart<?php echo $k;?>" id="add_to_cart<?php echo $k;?>" value="ADD TO CART" onClick="added(<?php echo "{$k}, '{$catagory_table}', {$itemid}, {$_SESSION['user']}";?>);" <?php if(isset($_SESSION['cart'][$itemid]) || ($userop->check_stock($itemid, $catagory_table)->error())){ ?>disabled="disabled" <?php } ?>><span class="glyphicon glyphicon-shopping-cart"></span></button> 
						<input type="button" class="btn btn-default btn-lg" name="add_to_wishlist<?php echo $k;?>" id="add_to_wishlist<?php echo $k;?>" value="ADD TO WISHLIST" onClick="added_to_wishlist(<?php echo "{$k}, '{$catagory_table}', {$itemid}, {$_SESSION['user']}";?>);" <?php if($user->isLoggedIn() || $guest){ if(($db->query("SELECT * FROM wishlist WHERE userid = ? AND itemid = ?", array($_SESSION['user'], $itemid), 'SELECT *')->count() != 0) || $guest){?>disabled="disabled" <?php } } ?>>
					</a>
				</div>
				<?php

			}

		}

		$cat_lists = $db->query("SELECT * FROM catagory_list", array(), 'SELECT *')->assocresults();
		$count4 = $db->count();
		$l = 1;
		
		for($i=0; $i<$count4; $i++){

			$cat_list = $cat_lists[$i];
			$item_results = $db->query("SELECT * FROM {$cat_list['catagory_table']} WHERE name LIKE '%$search_text%' OR brand LIKE '%search_text%'", array(), 'SELECT *')->results();
			$count5 = $db->count();
			$total_results += $count5;
			$catagory_table = $cat_list['catagory_table'];
			for($j=0; $j<$count5; $j++){

				$item = $item_results[$j];
				$itemid = $item->itemid;
				$k = $l.''.$i.''.$j;
				?>
				<div>
					<a href="display_item.php?catagory=<?php echo $catagory_table; ?>&&itemid=<?php echo $itemid; ?>">
						<img src="<?php echo $item->image;?>"  alt="<?php echo $item->name;?>" class="img-responsive" style="float: left"/>
						<h2><?php echo $item->name;?></h2></a>
						<small><?php echo $item->color;?></small></br>
						<small>by <?php echo $item->brand;?></small>
						<h3>Price: <?php echo $item->price;?></h3>
						<small style="font-color: red"><b><?php if($userop->check_stock($itemid, $catagory_table)->error()){?>Out of stock.<?php } ?></b></small>
						<span id="response_text<?php echo $k;?>"></span>
						<button type="button" class="btn btn-default btn-lg" name="add_to_cart<?php echo $k;?>" id="add_to_cart<?php echo $k;?>" value="ADD TO CART" onClick="added(<?php echo "{$k}, '{$catagory_table}', {$itemid}, {$_SESSION['user']}";?>);" <?php if(isset($_SESSION['cart'][$itemid]) || ($userop->check_stock($itemid, $catagory_table)->error())){ ?>disabled="disabled" <?php } ?>><span class="glyphicon glyphicon-shopping-cart"></span></button> 
						<input type="button" class="btn btn-default btn-lg" name="add_to_wishlist<?php echo $k;?>" id="add_to_wishlist<?php echo $k;?>" value="ADD TO WISHLIST" onClick="added_to_wishlist(<?php echo "{$k}, '{$catagory_table}', {$itemid}, {$_SESSION['user']}";?>);" <?php if($user->isLoggedIn() || $guest){ if(($db->query("SELECT * FROM wishlist WHERE userid = ? AND itemid = ?", array($_SESSION['user'], $itemid), 'SELECT *')->count() != 0) || $guest){?>disabled="disabled" <?php } } ?>>
					</a>
				</div>
				<?php				

			}
		}

		if($total_results == 0){

			?>
			<p> No results found. </p>
			<?php

		}

	}

?>