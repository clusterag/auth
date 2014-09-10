<?php
include "functions.php";

if (login() && is_admin()) {
	if ($_POST["username"] && is_user($_POST["username"]) && !$_POST["value"]){
		$username = $_POST["username"];
		$parameter = $_POST["parameter"];
		echo(make_html(True, change_user_template($username, $parameter)));
	}
	elseif ($_POST["username"] && is_user($_POST["username"]) && $_POST["value"]) {
		edit_user($username, $parameter, $value);
		echo(make_html(True, show_user($username)));
	}
}


?>