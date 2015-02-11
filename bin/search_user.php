<?php
include "functions.php";
//getting variables from post
$lastname = $_POST["lastname"];
//only accessible to admins
if (login() && is_admin()) {
	//if lastname has been posted look for the user
	if ($lastname){
		echo(make_html(True, file_get_contents($search_user_template_path) . search_user($lastname)));
	}
	//if lastname has not been posted display search form
	else{
		echo(make_html(True, file_get_contents($search_user_template_path)));
	}
}
