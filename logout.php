<?php
	session_set_cookie_params(300);
	session_start();
	//unsetting all session variables
	$_SESSION = array();
	session_destroy();
	header('Location: index.php');
?>