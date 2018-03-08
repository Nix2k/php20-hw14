<?php
	require_once './routines.php';
	
	try {
    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
    	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	if (isset($_GET['desc'])) {
		$description = clearInput($_GET['desc']);
		$sql_login = "SELECT `id` FROM `user` WHERE `login`='".$_SESSION['user']."'";
		$sql = "INSERT INTO `tasks` (`description`, `user_id `, `assigned_user_id`) VALUES ('".$description."', $sql_login, $sql_login)";
		echo $sql;
		$data = $pdo->query($sql);
		if (!$data) {
			die ('Ошибка!');
		}
	}
	header('Location: index.php');
?>
