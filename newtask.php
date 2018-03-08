<?php
	require_once './db-config.php';
	
	function clearInput($input) {
		return htmlspecialchars(strip_tags($input));
	}

	try {
    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
    	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	if (isset($_GET['desc'])) {
		$description = clearInput($_GET['desc']);
		$sql = "INSERT INTO `tasks` (`description`) VALUES ('".$description."')";
		$data = $pdo->query($sql);
		if (!$data) {
			die ('Ошибка!');
		}
	}
	header('Location: index.php');
?>
