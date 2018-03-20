<?php
	require_once './routines.php';
	$user = new User();

	if ($user->isLogedin()) {
		try {
	    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
	    	echo 'Подключение не удалось: ' . $e->getMessage();
		}

		if ((isset($_GET['submit'])) && (isset($_GET['assignie'])) && (isset($_GET['id']))) {
			$id = (int) $_GET['id'];
			$assignie = clearInput($_GET['assignie']);
			$sql = "SELECT * FROM `user` WHERE `login`='".$assignie."'";
			$data = $pdo->query($sql);
			foreach ($data as $row) {
				$sql = "UPDATE `task` SET `assigned_user_id`=".$row['id']." WHERE `id`=".$id;
				$data1 = $pdo->query($sql);
				header('Location: index.php');
			}
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
    <title>Назначение задачи</title>
</head>
<body>

<h1>Назначение задачи</h1>
<table>
	<tr>
		<th>id</th>
		<th>Описание</th>
		<th>Статус</th>
		<th>Дата добавления</th>
		<th>Автор</th>
		<th>Исполнитель</th>
		<th>Действия</th>
	</tr>
<?php
	if (isset($_GET['id'])) {
		if (is_numeric($_GET['id'])){
			$sql = "SELECT task.*, reporter.login AS rlogin, assignie.login AS alogin FROM task INNER JOIN user AS reporter ON task.user_id=reporter.id INNER JOIN user AS assignie ON task.assigned_user_id=assignie.id WHERE task.id=".$_GET['id'];
			$data = $pdo->query($sql);
			$sql1 = "SELECT * FROM user WHERE id!=".$user->getId( );
			$data1= $pdo->query($sql1);
			if ($data) {
				foreach ($data as $row) {
					$id = $row['id'];
					if ($row['is_done']==0) {
						$is_done = '<span style="color: red;">Не выполнено</span>';
					}
					else {
						$is_done = '<span style="color: green;">Выполнено</span>';
					}
					echo "<form action='assign.php'><input type='hidden' name='id' value='$id'>";
					echo "<tr>
						<td>$id</td>
						<td>".$row['description']."</td>
						<td>$is_done</td>
						<td>".$row['date_added']."</td>
						<td>".$row['rlogin']."</td>
						<td>
							<select name='assignie'>";
								foreach ($data1 as $row1) {
									if ($row1['login']==$row['alogin']) {
										$sel = 'selected';
									}
									else {
										$sel ='';
									}
									echo "<option ".$sel.">".$row1['login']."</option>";
								}
					echo "	</select>
						</td>
						<td><input type='submit' name='submit' value='Назначить'></td>
					</tr>";
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