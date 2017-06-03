<?php

require_once '../user_login/core/init.php';

$username = $_GET['username'];
$db = DB::getInstance();
$db->get('users', array('username', '=', $username));
$count = $db->count();
if($count == 0){

	echo "granted";

}else{

	echo "denied";

}

?>