<?php
include "functions.php";

if (login() && is_admin()) {
	if ($_POST["username"] && is_user($_POST["username"])){
		$username = $_POST["username"];
		if ($_POST["password"]) {
			del_user($username);
		}
	}
	elseif ($_POST["username"]){
		echo(make_html(True, "Benutzer existiert nicht." . file_get_contents($del_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($del_user_template_path)));
	}


}


?>