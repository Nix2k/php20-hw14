<?php

	require_once './routines.php';
	
	$user = new User();

	if ($user->isLogedin()) {
		header('Location: index.php');
	}
	if ((isset($_GET['submit'])) && (isset($_GET['login'])) && (isset($_GET['pass']))) {
		$login = clearInput($_GET['login']);
		$password = clearInput($_GET['pass']);
		if (!$user->getUserByLogin($login)) {
			if (checkPass($password)) {
				if ($user->addUser($login,$password)) {
					header('Location: index.php');
				}
				else {
					echo('<p style="text-align: center;">Ошибка регистрации пользователя</p>');
				}
			}
			else {
				echo('<p style="text-align: center;">Пароль не достаточно сложный<br>Пароль должен состоять минимум из 8 символов, содержать большие и маленькие буквы латинского алфавита и цифры</p>');
			}
		}
		else {
			echo('<p style="text-align: center;">Пользователь с таким именем уже зарегистрирован</p>');
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Регистрация нового пользователя</title>
</head>
<body style="text-align: center;">
<h1>Регистрация нового пользователя</h1>
<form action="registration.php">
	<input type="text" name="login" placeholder="Имя пользователя"><br>
	<input type="password" name="pass" placeholder="Пароль"><br>
	<input type="submit" name="submit" value="Зарегистрироваться"><br>
</form>
<a href="login.php">Вход для зарегистрированных пользователей</a>
</body>
</html>