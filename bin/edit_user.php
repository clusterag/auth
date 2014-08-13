<?php
include "functions.php";

if (login() && is_admin()) {
	$username = $_POST["username"];
	if ($username && is_user($username)){
		echo(make_html(True, show_user($username) . file_get_contents($edit_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($show_user_template_path)));
	}
	if ($_POST["firstname"]) {
		edit_user($username, "firstname", $_POST["firstname"]);
	}
	if ($_POST["lastname"]) {
		edit_user($username, "lastname", $_POST["lastname"]);
	}
	if ($_POST["password"]) {
		edit_user($username, "password", $_POST["password"]);
	}
}



?>
