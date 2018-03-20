<?php
	require_once './routines.php';

	$sort1 = '';
	$sort2 = '';
	
	if (isset($_GET['sort1'])) {
		$sort1 = clearInput($_GET['sort1']);
		$_SESSION['sort1'] = $sort1;
	}
	elseif (isset($_SESSION['sort1'])) {
		$sort1 = clearInput($_SESSION['sort1']);
	}

	if (isset($_GET['sort2'])) {
		$sort2 = clearInput($_GET['sort2']);
		$_SESSION['sort2'] = $sort2;
	}
	elseif (isset($_SESSION['sort2'])) {
		$sort2 = clearInput($_SESSION['sort2']);
	}

	$user = new User();

	if ($user->isLogedin()) {
		try {
			$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
			echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$sql1 = "SELECT task.*, reporter.login AS rlogin, assignie.login AS alogin FROM task INNER JOIN user AS reporter ON task.user_id=reporter.id INNER JOIN user AS assignie ON task.assigned_user_id=assignie.id WHERE task.user_id=".$user->getId( ).sort2order($sort1);
		$sql2 = "SELECT task.*, reporter.login AS rlogin, assignie.login AS alogin FROM task INNER JOIN user AS reporter ON task.user_id=reporter.id INNER JOIN user AS assignie ON task.assigned_user_id=assignie.id WHERE task.assigned_user_id=".$user->getId( )." AND reporter.id!=".$user->getId( ).sort2order($sort2);
		$dashboardIamReporter = new Dashboard($sql1);
		$dashboardMyTasks = new Dashboard($sql2);
	}
	else {
		header('Location: login.php');
	}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Задачи</title>
</head>
<body>

<form action="newtask.php" method="GET">
	<input type="text" name="desc" placeholder="Описание">
	<input type="submit" name="newtask" value="Добавить задачу">
</form>

<h2>Созданные мной задачи</h2>
<?php $dashboardIamReporter->printDashboard(); ?>

<h2>Назначенные мне задачи</h2>
<?php $dashboardMyTasks->printDashboard(); ?>

<a href="logout.php">Выйти</a>

</body>
</html>