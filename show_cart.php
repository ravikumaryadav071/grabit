<?php

	include'navbar.php';

	if($user->isLoggedIn()){

		if(isset($_SESSION['cart'])){

			?>
			</br>
			</br>
			</br>
			</br>
			<p><b>Your Cart</p></b>

			<?php

			$cart1 = $_SESSION['cart'];
			
			foreach($cart1 as $key=>$value){

				$item = $db->get($value['catagory'], array('itemid', '=', $value['itemid']))->first();
				?>
				<div name="item<?php echo $key;?>" id="item<?php echo $key;?>">
					<button type="button" class="close" name="button<?php echo $key;?>" id="button<?php echo $key;?>" area-hidden="true" onClick="remove_from_cart(<?php echo "{$key}, {$value['itemid']}";?>);">
						&times;
					</button>
					<div id="response_text<?php echo $key;?>" name="response_text<?php echo $key;?>"></div>
					<a href="display_item.php?catagory=<?php echo $value['catagory'];?>&&itemid=<?php echo $value['itemid'];?>">
						<img src="<?php echo $item->image;?>" class="img img-responsive" style="float: left">
						<h3><b><?php echo $item->name;?></b></h3>
					</a>
					<small>
						<?php echo $item->color;?>
						</br>
						by <?php echo $item->brand;?>
					</small>
					<p>
						<lable for="qty<?php echo $key;?>">Quantity: </lable>
						<input type="number" name="qty<?php echo $key;?>" id="qty<?php echo $key;?>" value="<?php echo $value['qty'];?>" max="10" min="0">
						<button type="button" class="btn btn-default btn-md" name="save<?php echo $key;?>" id="save<?php echo $key;?>" onClick="save_changes(<?php echo "{$key}, {$value['itemid']}";?>);">
							Save
						</button>
					</p>
					<h4><b>Price: <?php echo $item->price;?></b></h4>
				</div>
				<?php

			}
			?>
			<div>
				<h4>
					<b id="total_amount">
						Total Amount: <?php echo $cart->total_price();?>
					</b>
					</br>
					<b id="total_qty">
						Quantity: <?php echo $cart->total_qty();?>
					</b>
				</h4>
				<?php
				if(!empty($_SESSION['cart'])){
					?>
					<a href="place_order.php">
						<button type="button" class="btn btn-default btn-lg btn-primary btn-block">Place Order</button>
					</a>
					<?php
				}
				?>
		    </div>
			<?php

		}else{

			?>
			<p>Your cart is empty.</p>
			<?php

		}
	}else{

		redirect::to('login.php');

	}
?>
<script type="text/javascript" src="javascripts/edit_cart.js"></script>
</body>
</html>