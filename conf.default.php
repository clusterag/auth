<?php
$root = "/path/to/auth";
$login_template_path = $root . "template/login.snippet";
$logout_template_path = $root . "template/logout.snippet";
$admin_login_template_path = $root . "template/login_admin.snippet";

$template = $root . "template/template.html";

$db_host = "db.host.tld";  //$dbhost
$db_user = "dbuser1234";  //$dbuser
$db_password = "dbpassword";  // passwort der Datenbank
$db_database = "database1234";  // Name der Datenbank.
//TODO: move this to the code
$error_not_logged_in = "Benutzername oder Passwort sind falsch. Bitte versuchen Sie es erneut.";

$heute = $root . "tables/heute.table";
$heute_raw = $root . "raw/heute.htm";
$morgen = $root . "tables/morgen.table";
$morgen_raw = $root . "raw/morgen.htm";
//switches files delivered from heute.php and morgen.php to raw/$.htm if set to True.
$disable_python = False;
?>
