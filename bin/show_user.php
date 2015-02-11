<?php
include "functions.php";
//only accessible to admins
if (login() && is_admin()) {
	//if username has been posted and exists
	if ($_POST["username"] && is_user($_POST["username"])){
		//getting username from POST
		$username = $_POST["username"];
		echo(make_html(True, show_user($username) . file_get_contents($show_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($show_user_template_path)));
	}
}
?>
