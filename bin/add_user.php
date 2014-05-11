<?php
include "functions.php";

if (login() && is_admin()) {
	if ($_POST["username"] && $_POST["password"]){
		if ($_POST["teacher"] == "2") {
			$teacher = True;
		}
		else {
			$teacher = False;
		}
		add_user($_POST["username"], $_POST["password"], $teacher);
		echo(make_html(True, "Benutzer \"" . $_POST["username"] . "\" wurde erstellt" . file_get_contents($add_user_template_path)));
	}
	elseif ($_POST["username"]) {
		echo(make_html(True, "Bitte geben sie ein Passwort ein. " . file_get_contents($add_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($add_user_template_path)));
	}
	

}


?>