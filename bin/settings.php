<?php
include "functions.php";

if (login()){
	if ($_POST["password_1"]){
		if (!(check_password($_SESSION["username"], $_POST["password"]))){
			echo (make_html(True, "Altes Passwort stimmt nicht." . file_get_contents($settings_template_path)));
		}
		elseif (!($_POST["password_1"] == $_POST["password_2"])){
			echo (make_html(True, "Neue Passw&ouml;rter stimmen nicht uberein." . file_get_contents($settings_template_path)));
		}
		else {
			set_password($_SESSION["username"], $_POST["password_1"]);
			echo (make_html(True, "Passwort erfolgreich ge&auml;ndert." . file_get_contents($settings_template_path)));
		}
	}
	else {
		echo (make_html(True, file_get_contents($settings_template_path)));
	}
}


?>
