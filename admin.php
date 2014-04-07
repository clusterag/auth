<?php
include "index.php";
if (login($login_template_path, $error_not_logged_in, $dbhost, $dbuser, $dbp, $db_database, "users")) {
	echo(file_get_contents($admin_template_path));

}


?>