<?php
include "functions.php";
//only accessible to admins
if (login() && is_admin()) {
	//if no value has been posted echo user details
	if ($_POST["username"] && is_user($_POST["username"]) && !$_POST["value"]){
		//getting variables from POST
		$username = $_POST["username"];
		$parameter = $_POST["parameter"];
		echo(make_html(True, change_user_template($username, $parameter)));
	}
	//if values have been posted 
	elseif ($_POST["username"] && is_user($_POST["username"]) && $_POST["value"] && $_POST["parameter"]) {
		//getting variables from POST
		$username = $_POST["username"];
		$parameter = $_POST["parameter"];
		$value = $_POST["value"];
		//make the changes
		edit_user($username, $parameter, $value);
		//show user details
		echo(make_html(True, show_user($username)));
	}
}
?>
