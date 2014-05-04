<?php
include "functions.php";

if (login()){
	if ($_POST["password_1"]){
		if (($_POST["password_1"] == $_POST["password_2"]) && password_verify($_SESSION["username"], $_POST["password"])) {
			set_password($_SESSION["username"], $_POST[password_1]);
		}
	}
	echo (make_html(True, file_get_contents($settings_template_path)));
}


?>
