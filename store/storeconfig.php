<?php
class storeconfig{
	public static function get($path = null){
		if($path){
			$config = $GLOBALS['storeconfig'];
			$path = explode('/', $path);

			foreach($path as $bit){

				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
}

?>