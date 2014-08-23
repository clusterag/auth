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
$error_not_logged_in = "Benutzername oder Passwort sind falsch. Bitte versuchen Sie es erneut.";

$heute = $root . "tables/heute.table";
$heute_raw = $root . "raw/heute.html";
$morgen = $root . "tables/morgen.table";
$morgen_raw = $root . "raw/morgen.html";
$disable_python = False;
?>
