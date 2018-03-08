<?php

	require_once './db-config.php';
	
	try {
    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
    	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	$sql = "SELECT * FROM `tasks`";	
	$data = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Задачи</title>
</head>
<body>

<h1>Мои задачи</h1>
<form action="newtask.php" method="GET">
	<input type="text" name="desc" placeholder="Описание">
	<input type="submit" name="newtask" value="Добавить задачу">
</form>
<table>
	<tr>
		<th>id</th>
		<th>Описание</th>
		<th>Статус</th>
		<th>Дата добавления</th>
		<th colspan="2">Действия</th>
	</tr>
<?php
	if ($data) {
		foreach ($data as $row) {
			$id = $row['id'];
			if ($row['is_done']==0) {
				$is_done = '<span style="color: red;">Не выполнено</span>';
				$workflow = "<a href='done.php?id=$id'>Выполнено</a>";
			}
			else {
				$is_done = '<span style="color: green;">Выполнено</span>';
				$workflow = "<a href='reopen.php?id=$id'>Открыть заново</a>";
			}
			echo "<tr><td>$id</td><td>".$row['description']."</td><td>$is_done</td><td>".$row['date_added']."</td><td>$workflow</td><td><a href='delete.php?id=$id'>Удалить</a></td></tr>";
		}
	}
	else {
		echo "Нет результатов";
	}
?>
</table>

</body>
</html>