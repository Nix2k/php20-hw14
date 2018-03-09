<?php

class User 
{
	private $salt = 'f1b78b02cafb265e4fc6f2a70e391568';
	private $id;
	private $login;
	private $password;

	public function getUserByLogin ($login)
	{
		require './db.php';
		try {
	    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
	    	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$sql = "SELECT * FROM `user` WHERE `login`='".$login."'";
		$data = $pdo->query($sql);
		if ($data) {
			foreach ($data as $user) {
				$this->id = $user['id'];
				$this->login = $user['login'];
				$this->password = $user['password'];
				return true;
			}
		}
		return false;
	}

	public function addUser ($login, $password)
	{
		$this->password = hash('sha256', $password.$this->salt);
		$this->login = $login;
		require './db.php';
		try {
	    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
	    	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$sql = "INSERT INTO `user` (`login`, `password`) VALUES ('".$this->login."', '".$this->password."')";
		return $pdo->query($sql);
	}

	public function loginUser ($login, $password)
	{
		$password = hash('sha256', $password.$this->salt);
		require './db.php';
		try {
	    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
	    	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$sql = "SELECT * FROM `user` WHERE `login`='".$login."' AND `password`='".$password."'";
		if ($pdo->query($sql)->rowCount()==1){
			$_SESSION['user'] = $login;
			$_SESSION['password'] = $password;
			return true;
		}
		else {
			return false;
		}
	}

	public function isLogedin ()
	{
		if ((isset($_SESSION['user']))&&(isset($_SESSION['password']))) {
			$login = clearInput($_SESSION['user']);
			$hash = clearInput($_SESSION['password']);
			if ($this->getUserByLogin($login)){
				require './db.php';
				try {
			    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
				} catch (PDOException $e) {
			    	echo 'Подключение не удалось: ' . $e->getMessage();
				}
				$sql = "SELECT * FROM `user` WHERE `login`='".$login."' AND `password`='".$hash."'";
				$data = $pdo->query($sql);
				if ($data) {
					foreach ($data as $user) {
						$this->id = $user['id'];
						$this->login = $user['login'];
						$this->password = $user['password'];
						return true;
					}
				}
			}
		}
		return false;
	}

	public function getId ()
	{
		return $this->id;
	}
}
?>
