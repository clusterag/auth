<?php
include "functions.php";

if (login() && is_admin() && $_SESSION["username"] == "admin" ) {
	get_user_list();
	//echo(make_html(True, get_user_list()));

}


?>
