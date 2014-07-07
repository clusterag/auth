//THIS FILE TEMPORARILY CONTAINS log.php
//<?php
//include "functions.php";
//
//if (login() && is_admin() && $_SESSION["username"] == "admin" ) {
//
//	echo(make_html(True, get_user_list()));
//
//}
//
//
//?>
<?php
include "functions.php";

if (login() && is_admin() && $_SESSION["username"] == "admin" ) {

	echo(make_html(True, file_get_contents($log_path)));

}


?>
