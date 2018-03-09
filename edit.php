<?php
	require_once './routines.php';
	$user = new User();

	if ($user->isLogedin()) {
		try {
	    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
	    	echo 'Подключение не удалось: ' . $e->getMessage();
		}

		if ((isset($_GET['submit'])) && (isset($_GET['desc'])) && (isset($_GET['id']))) {
			$id = (int) $_GET['id'];
			$description = clearInput($_GET['desc']);
			$sql = "UPDATE `task` SET `description`='".$description."' WHERE `id`=".$id;
			$data = $pdo->query($sql);
			header('Location: index.php');
		}
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
    <title>Редактирование задачи</title>
</head>
<body>

<h1>Редактирование задачи</h1>
<table>
	<tr>
		<th>id</th>
		<th>Описание</th>
		<th>Статус</th>
		<th>Дата добавления</th>
		<th>Действия</th>
	</tr>
<?php
	if (isset($_GET['id'])) {
		if (is_numeric($_GET['id'])){
			$sql = "SELECT * FROM `task` WHERE `id`=".$_GET['id'];
			$data = $pdo->query($sql);
			if ($data) {
				foreach ($data as $row) {
					$id = $row['id'];
					if ($row['is_done']==0) {
						$is_done = '<span style="color: red;">Не выполнено</span>';
					}
					else {
						$is_done = '<span style="color: green;">Выполнено</span>';
					}
					echo "<form action='edit.php'><input type='hidden' name='id' value='$id'>";
					echo "<tr><td>$id</td><td><input type='text' name='desc' value='".$row['description']."'></td><td>$is_done</td><td>".$row['date_added']."</td><td><input type='submit' name='submit' value='Готово'></td></tr>";
					echo "</form>";
				}
			}
			else {
				echo "Нет результатов";
			}
		}
		else {
			die ('Ошибка. Нверный идентификатор задачи.');
		}
	}
	else header('Location: index.php');
?>
</table>
<a href="index.php">Главная</a>

</body>
</html>