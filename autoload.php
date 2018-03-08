<?php
	spl_autoload_register(
		function($className){
			$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className);
			if (file_exists("./classes/$fileName.php")) {
				require_once "./classes/$fileName.php";
			}
			else {
				die ("Класс $className не существует");
			}
		}
	);
?>