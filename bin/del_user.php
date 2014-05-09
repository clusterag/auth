<?php
include "functions.php";

$username = $_POST["username"];

if (login() && is_admin()) {
	//if ($username && is_user($username)){
	if ($username){
			del_user($username);
	}
	elseif ($username){
		echo(make_html(True, "Benutzer existiert nicht." . file_get_contents($del_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($del_user_template_path)));
	}


}


?>