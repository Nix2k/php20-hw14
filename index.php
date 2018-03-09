<?php
	require_once './routines.php';
	
	function sort2order ($sort)
	{
		switch ($sort) {
			case 'desc':
				return ' ORDER BY `description`';
			case 'status':
				return ' ORDER BY `is_done`';
			case 'date':
				return ' ORDER BY `date_added`';
		}
		return '';
	}

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
		$sql1 = "SELECT * FROM `task` WHERE `user_id`=".$user->getId( ).sort2order($sort1);	
		$data1 = $pdo->query($sql1);
		$sql2 = "SELECT * FROM `task` WHERE `assigned_user_id`=".$user->getId( ).sort2order($sort2);	
		$data2 = $pdo->query($sql2);
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

<h2>Созданные мной задачи</h2>
<form action="newtask.php" method="GET">
	<input type="text" name="desc" placeholder="Описание">
	<input type="submit" name="newtask" value="Добавить задачу">
</form>
<table>
	<tr>
		<th>id</th>
		<th><a href="index.php?sort1=desc">Описание</a></th>
		<th><a href="index.php?sort1=status">Статус</a></th>
		<th><a href="index.php?sort1=date">Дата добавления</a></th>
		<th colspan="3">Действия</th>
	</tr>
<?php
	if ($data1) {
		foreach ($data1 as $row) {
			$id = $row['id'];
			if ($row['is_done']==0) {
				$is_done = '<span style="color: red;">Не выполнено</span>';
				$workflow = "<a href='done.php?id=$id'>Выполнено</a>";
			}
			else {
				$is_done = '<span style="color: green;">Выполнено</span>';
				$workflow = "<a href='reopen.php?id=$id'>Открыть заново</a>";
			}
			echo "<tr><td>$id</td><td>".$row['description']."</td><td>$is_done</td><td>".$row['date_added']."</td><td>$workflow</td><td><a href='edit.php?id=$id'>Редактировать</a></td><td><a href='delete.php?id=$id'>Удалить</a></td></tr>";
		}
	}
	else {
		echo "Нет результатов";
	}
?>
</table>

<h2>Назначенные мне задачи</h2>
<table>
	<tr>
		<th>id</th>
		<th><a href="index.php?sort2=desc">Описание</a></th>
		<th><a href="index.php?sort2=status">Статус</a></th>
		<th><a href="index.php?sort2=date">Дата добавления</a></th>
		<th colspan="3">Действия</th>
	</tr>
<?php
	if ($data2) {
		foreach ($data2 as $row) {
			$id = $row['id'];
			if ($row['is_done']==0) {
				$is_done = '<span style="color: red;">Не выполнено</span>';
				$workflow = "<a href='done.php?id=$id'>Выполнено</a>";
			}
			else {
				$is_done = '<span style="color: green;">Выполнено</span>';
				$workflow = "<a href='reopen.php?id=$id'>Открыть заново</a>";
			}
			echo "<tr><td>$id</td><td>".$row['description']."</td><td>$is_done</td><td>".$row['date_added']."</td><td>$workflow</td><td><a href='edit.php?id=$id'>Редактировать</a></td><td><a href='delete.php?id=$id'>Удалить</a></td></tr>";
		}
	}
	else {
		echo "Нет результатов";
	}
?>
</table>
<a href="logout.php">Выйти</a>

</body>
</html>