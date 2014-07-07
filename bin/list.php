<?php
//THIS FILE TEMPORARILY CONTAINS log.php
//
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

	echo(make_html(True, "THIS FILE TEMPORARILY CONTAINS log.php" . file_get_contents($log_path)));

}


?>
