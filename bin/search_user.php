<?php
include "functions.php";
$lastname = $_POST["lastname"];
if (login() && is_admin()) {
	if ($lastname){
		echo(make_html(True, file_get_contents($search_user_template_path) . search_user($lastname)));
	}
	else{
		echo(make_html(True, file_get_contents($search_user_template_path)));
	}
}


