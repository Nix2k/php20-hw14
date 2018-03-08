<?php
	require_once './autoload.php';
	require_once './db.php';

	session_start();

	function clearInput($input) {
		return htmlspecialchars(strip_tags($input));
	}

	function checkPass($password) {
		if ((strlen($password)>=8) && ((preg_match('/[a-z]/'))*(preg_match('/[A-Z]/'))*(preg_match('/[0-9]/'))==1)){
			return true;
		}
		return false;
	}
?>