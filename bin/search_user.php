<?php
include "functions.php";
$lastname = $_POST["lastname"];
if (login() && is_admin()) {
	if ($lastname){
		echo "test123";
		echo(make_html(True, search_user($lastname)));
		echo "test321";
	}
	else{
		echo(make_html(True, file_get_contents($search_user_template_path)));
	}
}


