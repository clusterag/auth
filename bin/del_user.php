<?php
include "functions.php";

$username = $_POST["username"];

if (login() && is_admin() && is_user($username) ) {
	if ($username && $username != "admin"){
			del_user($username);
			echo(make_html(True, "Benutzer \"" . $username . "\" gelöscht" . file_get_contents($del_user_template_path)));
	}
	elseif ($username){
		echo(make_html(True, "Benutzer \"" . $username . "\" existiert nicht." . file_get_contents($del_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($del_user_template_path)));
	}


}

echo(is_user($username));

?>
