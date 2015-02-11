<?php
//this is effectively change_password.php
//TODO: rename
include "functions.php";
if (login()){
	//TODO: rename this variable
	//if new password has been posted
	if ($_POST["password_1"]){
		//if old password does not match display error message
		if (!(check_password($_SESSION["username"], $_POST["password"]))){
			echo (make_html(True, "Altes Passwort stimmt nicht." . file_get_contents($settings_template_path)));
		}
		//if new passwords don't match
		elseif (!($_POST["password_1"] == $_POST["password_2"])){
			echo (make_html(True, "Neue Passw&ouml;rter stimmen nicht uberein." . file_get_contents($settings_template_path)));
		}
		//if everything is alright change password and display success message
		else {
			set_password($_SESSION["username"], $_POST["password_1"]);
			echo (make_html(True, "Passwort erfolgreich ge&auml;ndert." . file_get_contents($settings_template_path)));
		}
	}
	//if no new password has been posted
	else {
		echo (make_html(True, file_get_contents($settings_template_path)));
	}
}
?>
