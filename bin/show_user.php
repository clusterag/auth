<?php
include "functions.php";

if (login() && is_admin()) {
	if ($_POST["username"] && is_user($_POST["username"])){
		$username = $_POST["username"];
		echo(make_html(True, show_user($username) . file_get_contents($show_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($show_user_template_path)));
	}
}


?>