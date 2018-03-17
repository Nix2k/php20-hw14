<?php
	require_once './autoload.php';
	require_once './db.php';

	session_start();

	function clearInput($input) 
	{
		return htmlspecialchars(strip_tags($input));
	}

	function checkPass($password) 
	{
		if ((strlen($password)>=8) && ((preg_match('/[a-z]/',$password))*(preg_match('/[A-Z]/',$password))*(preg_match('/[0-9]/',$password))==1)){
			return true;
		}
		return false;
	}

	function sort2order ($sort)
	{
		switch ($sort) {
			case 'desc':
				return ' ORDER BY description';
			case 'status':
				return ' ORDER BY is_done';
			case 'date':
				return ' ORDER BY date_added';
		}
		return '';
	}
?>