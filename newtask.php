<?php
require_once './routines.php';

$user = new User();
if ($user->isLogedin()) {
	if (isset($_GET['desc'])) {
		$description = clearInput($_GET['desc']);
		try {
	    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
	    	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$uId = $user->getId();
		$sql = "INSERT INTO `task` (`description`, `user_id`, `assigned_user_id`) VALUES ('".$description."', $uId, $uId)";
		$data = $pdo->query($sql);
		if (!$data) {
			die ('Ошибка!');
		}
	}
}
header('Location: index.php');
?>
