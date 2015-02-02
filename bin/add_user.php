<?php
include "functions.php";
if (login() && is_admin()) {
	if ($_POST["username"] && $_POST["password"]){
		add_user($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["password"], False, $_POST["class"]);
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
