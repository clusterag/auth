<?php
include "functions.php";
//getting variables from post
$username = $_POST["username"];
$admin = $_POST["admin"];
//only accessible to user admin
if (login() && is_admin() && $_SESSION["username"] == "admin" ) {
	//remove admin status from posted username
	if ($username && $admin == "2"){
		echo($username);
		make_admin($username, True);
	}
	//make posted username an admin
	elseif ($username && $admin == "1"){
		make_admin($username, False);
	}
	//echo full user list
	echo(make_html(True, get_user_list()));
}
