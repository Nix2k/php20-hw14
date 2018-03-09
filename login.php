<?php

	require_once './routines.php';
	
	$user = new User();

	if ($user->isLogedin()) {
		header('Location: index.php');
	}
	if ((isset($_GET['submit'])) && (isset($_GET['login'])) && (isset($_GET['pass']))) {
		$login = clearInput($_GET['login']);
		$password = clearInput($_GET['pass']);
		if ($user->loginUser($login,$password)) {
			header('Location: index.php');
		}
		else {
			echo('<p style="text-align: center;">Неверное имя пользователя или пароль</p>');
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Вход на сайт</title>
</head>
<body style="text-align: center;">
<h1>Вход на сайт</h1>
<form action="login.php">
	<input type="text" name="login" placeholder="Имя пользователя"><br>
	<input type="password" name="pass" placeholder="Пароль"><br>
	<input type="submit" name="submit" value="Вход"><br>
</form>
<a href="registration.php">Регистрация нового пользователя</a>
</body>
</html>