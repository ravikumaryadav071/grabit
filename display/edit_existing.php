<?php

require_once'c:/xampp/htdocs/grabit/user_login/core/init.php';

 $user = new user();
 if($user->isLoggedIn()){
 	if($user->hasPermission('admin')){
$db = DBstore::getstoreInstance();

if(isset($_GET['table_name'])){

	$results = $db->query("SELECT * FROM {$_GET['table_name']}", array(), 'SELECT *')->results();
	$assocresults = $db->assocresults();
	$count = $db->count();

}

if(!empty($_POST)){
	if(isset($_POST['save_changes']) && isset($_POST['result_no'])){

		$res = $assocresults[$_POST['result_no']];
		$arr = array();
		foreach($res as $key=>$value){
			if(!($key == 'itemid')){

				$arr[$key] = $_POST[$key]; 
			}
		}
		$db->update($_GET['table_name'], $arr, array('itemid', '=', $res['itemid']));
		if(!$db->error()){

			echo "Your changes have saved sucessfully.";

		}
	}

	if(isset($_POST['delete']) && isset($_POST['result_no'])){

		$res = $assocresults[$_POST['result_no']];
		$db->delete($_GET['table_name'],array('itemid', '=', $res['itemid']));
		if(!$db->error()){

			echo "Item has deleted sucessfully.";

		}

	}
}

if(isset($_GET['table_name'])){

	$results = $db->query("SELECT * FROM {$_GET['table_name']}", array(), 'SELECT *')->results();
	$assocresults = $db->assocresults();
	$count = $db->count();

}

?>

<?php
for($i=0; $i<$count; $i++){
	$assocresult = $assocresults[$i];
	?>
	<form action="" method="POST">
	<fieldset><legend> <?php echo $assocresult['name']; ?> </legend>
		<div class="field">
	
	<?php

foreach($assocresult as $key=>$value){

?>
	<lable for="<?php echo $key;?>"><?php echo $key;?></lable>
	<input type="text" name="<?php echo $key;?>" id="<?php echo $key;?>" value="<?php echo $value;?>" autocomplete="off" <?php if($key == 'itemid'){ ?> disabled="disabled" <?php } ?> >

<?php
	}
	?>
	<input type="submit" name="save_changes" id="save_changes" value="SAVE CHANGES">
	<input type="submit" name="delete" id="delete" value="DELETE">
	<input type="hidden" name="result_no" id="result_no" value="<?php echo $i;?>">
</div>
</fieldset>
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