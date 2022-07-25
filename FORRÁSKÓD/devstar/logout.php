<?php
	header('Content-type: text/html; charset=utf-8');

	require_once 'classes/users_class.php';
	use classes\Users;

	Users::userLogout();
?>