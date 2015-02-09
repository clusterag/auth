<?php
include "functions.php";
$username = $_POST["username"];
$admin = $_POST["admin"];
if (login() && is_admin() && $_SESSION["username"] == "admin" ) {
	if ($username && $admin == "2"){
		echo($username);
		make_admin($username, True);
	}
	elseif ($username && $admin == "1"){
		make_admin($username, False);
	}
	echo(make_html(True, get_user_list()));
}
