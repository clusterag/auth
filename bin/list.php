<?php
include "functions.php";

if (login() && is_admin() && $_SESSION["username"] == "admin" ) {

	echo(make_html(True, get_user_list()));
	make_admin("rct");

}


