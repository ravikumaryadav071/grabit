<?php

require_once 'c:/xampp/htdocs/grabit/user_login/core/init.php';

$user = new user();
if($user->isLoggedIn()){
	if($user->hasPermission('admin')){
$db = DBstore::getstoreInstance();

if(isset($_GET['table_name'])){

	$results = $db->query("SELECT * FROM {$_GET['table_name']}", array(), 'SELECT *')->results();
	$assocresults = $db->assocresults();
	$count = $db->count();

}

$keys = array_keys($assocresults[0]);
if(!empty($_POST)){

	$res = $db->query("SELECT * FROM {$_GET['table_name']} WHERE name = ? AND color = ?", array($_POST['name'], $_POST['color']), 'SELECT *')->results();
	if(!empty($res)){

	echo "This item is already exists";

}
	if(isset($_POST['add']) && empty($res)){
		foreach($assocresults[0] as $key=>$value){

			if(!($key == 'itemid')){
				$arr[$key] = $_POST[$key];
			}

		}
		$db->insert($_GET['table_name'], $arr);
		if(!$db->error()){

			echo"1 row inserted";

		}
	}

}
?>
<form action="" method="post">
<?php
foreach($keys as $key){

?>

<lable for="<?php echo $key;?>"><?php echo $key;?></lable>
<input type="text" name="<?php echo $key;?>" id="<?php echo $key;?>" value="" <?php if($key == 'itemid'){?> disabled="disabled" <?php } ?>>

<?php

}

?>
<input type="submit" name="add" id="add">
</form>
<p>Go to <a href="index.php">home</a> page.</p>
<?php
}
}
else{
	echo '<p>You need to <a href="login.php">login</a></p>';
	}
?>
<p>Go to<a href="index.php"> home.</a></p>