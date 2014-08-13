<?php
include "functions.php";

if (login() && is_admin()) {

	if ($_POST["username"] && $_POST["password"]){
			add_user($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["password"], True);
			echo(make_html(True, "Lehrer \"" . $_POST["username"] . "\" wurde erstellt" . file_get_contents($teachers_template_path)) . get_user_list(True));
		}
		elseif ($_POST["username"]) {
			echo(make_html(True, "Bitte geben sie ein Passwort ein. " . file_get_contents($teachers_template_path)) . get_user_list(True));
		}
		else {
			echo(make_html(True, file_get_contents($teachers_template_path) . get_user_list(True)));
	}

}


?>
