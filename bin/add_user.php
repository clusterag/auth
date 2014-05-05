<?php
include "functions.php";

if (login() && is_admin()) {
	if ($_POST["username"]){
		
	}
	else {
		echo(make_html(True, file_get_contents($add_user_template_path)));
	}
	

}


?>