<?php
require_once 'user_login/core/init.php';

 $user = new user();
 if($user->isLoggedIn()){
 	if($user->hasPermission('admin')){

$db = DBstore::getstoreInstance();
$result = $db->query('SELECT * FROM catagory_list',array(),'SELECT *')->results();
$count = $db->count();

if(!empty($_POST)){

	if (isset($_POST['edit_existing_catagory_items']) && isset($_POST['result_no'])) {
		$addr = 'edit_existing.php?table_name='.$result[$_POST['result_no']]->catagory_table;
		redirect::to($addr);
	}

	if (isset($_POST['add_new_item']) && isset($_POST['result_no'])) {
		$addr = 'add_new_item.php?table_name='.$result[$_POST['result_no']]->catagory_table;
		redirect::to($addr);
	}

	if (isset($_POST['find_by_field']) && isset($_POST['result_no'])) {
		$addr = 'get_item_by_field.php?table_name='.$result[$_POST['result_no']]->catagory_table;
		redirect::to($addr);
	}

	if (isset($_POST) && isset($_POST['result_no'])) {

	}

	if (isset($_POST) && isset($_POST['result_no'])) {

	}
}


for($i = 0; $i<$count; $i++){

	$catagory_name = $result[$i]->catagory_name;
	$catagory_table = $result[$i]->catagory_table;
?>
<form action="" method="post">
	<p>
		<?php echo $catagory_name; ?>
		<input type="submit" name="edit_existing_catagory_items" id="edit_existing_catagory_items" value="Edit Existing Catagory Items">
		<input type="submit" name="add_new_item" id="add_new_item" value="Add New Item">
		<input type="submit" name="find_by_field" id="find_by_field" value="Find Item by Field">
		<input type="submit" name="" id="" value="">
		<input type="submit" name="" id="" value="">
		<input type="hidden" name="result_no" id="result_no" value="<?php echo $i ?>">
	</p>
</form>
<?php
}
}
}
else{
	echo '<p>You need to <a href="login.php">login</a></p>';
	}
?>
<p>Go to <a href="index.php">home</a> page.</p>