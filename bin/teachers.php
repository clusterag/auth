<?php
include "functions.php";
//only accessible to admins
if (login() && is_admin()) {
	//if username and password have been posted, create new teacher account
	//TODO: check if user exists
	if ($_POST["username"] && $_POST["password"]){
			add_user($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["password"], True);
			echo(make_html(True, "Lehrer \"" . $_POST["username"] . "\" wurde erstellt" . file_get_contents($teachers_template_path)) . get_user_list(True));
		}
	//if no password has been posted, display error message
	elseif ($_POST["username"]) {
		echo(make_html(True, "Bitte geben sie ein Passwort ein. " . file_get_contents($teachers_template_path)) . get_user_list(True));
		}
	//if nothing has been posted display form
	else {
		echo(make_html(True, file_get_contents($teachers_template_path) . get_user_list(True)));
	}
}
?>
