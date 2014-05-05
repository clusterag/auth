<?php
include "functions.php";

if (login() && is_admin()) {
	if ($_POST["username"] && is_user($_POST["username"])){
		$username = $_POST["username"];
		if ($_POST["password"]) {
			set_password($username, $_POST["password"]);
		}
		if ($_POST["teacher"] == "2"){
			echo "2";
			set_teacher($username, True);
		}
		else {
			echo "1";
			set_teacher($username, False);
		}
	}
	elseif ($_POST["username"]){
		echo(make_html(True, "Benutzer existiert nicht." . file_get_contents($edit_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($edit_user_template_path)));
	}


}


?>