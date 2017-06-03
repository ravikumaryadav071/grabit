<?php
	
	require_once '../user_login/core/init.php';
	$db = DBstore::getstoreInstance();
	$search_text = escape($_GET['search_text']);
	$catagory = $db->query("SELECT * FROM catagory_list WHERE catagory_name LIKE '%$search_text%'", array(), 'SELECT *')->assocresults();
	$count1 = $db->count();
	$str = "";
	$search = true;

	if($search_text == ''){

		$search = false;

	}

	if($search){

		for($i=0; $i<$count1; $i++){

			$result1 = $catagory[$i];
			if($str == ""){

				$str.=$result1['catagory_name'];

			}else{

				$str.=",{$result1['catagory_name']}";

			} 

		}

		$catagories = $db->query("SELECT * FROM catagory_list", array(), 'SELECT *')->assocresults();
		$count2 = $db->count();
		
		for($i=0; $i<$count2; $i++){

			$result2 = $catagories[$i];
			$catagory_table = $result2['catagory_table'];
			$items = $db->query("SELECT * FROM {$catagory_table} WHERE name LIKE '%$search_text%'  OR brand LIKE '%$search_text%'", array(), 'SELECT *')->assocresults();
			$count3 = $db->count();
			for($j=0; $j<$count3; $j++){

				$item = $items[$j];
				if($str==""){

					$str.=$item['name'];
					if(!strpos($str, $item['brand'])){
						$str.=",".$item['brand'];
					}

				}else{

					$str.=",".$item['name'];
					if(!strpos($str, $item['brand'])){
						$str.=",".$item['brand'];
					}

				}

			}

		}

		echo $str;
	}
?>