<?php
include "functions.php";
$username = $_POST["username"];
//only accessible to admins
if (login() && is_admin() ) {
	//user admin cannot be deleted
	if ($username && $username != "admin"){
			//delete the user
			del_user($username);
			//success message
			echo(make_html(True, "Benutzer \"" . $username . "\" gel&ouml;scht" . file_get_contents($del_user_template_path)));
	}
	//if admin was posted as username echo error message
	elseif ($username){
		echo(make_html(True, "Benutzer \"" . $username . "\" existiert nicht." . file_get_contents($del_user_template_path)));
	}
	//if no username has been posted
	else {
		echo(make_html(True, file_get_contents($del_user_template_path)));
	}
}
?>
