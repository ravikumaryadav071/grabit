<?php
class redirect{

	public static function to($location = NULL){

		if($location){

			if(is_numeric($location)){

				switch($location){

					case 404:
					header('HTTP/1.0 404 Not Found');
					include'store/errors/404.php';
					exit();
					break;

				}

			}
			header('Location:'.$location);
			exit();
		}

	}

}

?>