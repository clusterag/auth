<?php
include "functions.php";
//this page is only accessible to admins
if (login() && is_admin())
	//check if a username and a password have been posted
	if ($_POST["username"] && $_POST["password"]){
		//add the user to the database
		add_user($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["password"], False, $_POST["class"]);
		//success message
		echo(make_html(True, "Benutzer \"" . $_POST["username"] . "\" wurde erstellt" . file_get_contents($add_user_template_path)));
	}
	//ask to post a password if only a username has been posted
	elseif ($_POST["username"]) {
		echo(make_html(True, "Bitte geben sie ein Passwort ein. " . file_get_contents($add_user_template_path)));
	}
	//if no username has been posted, display the form
	else {
		echo(make_html(True, file_get_contents($add_user_template_path)));
	}
}
?>
