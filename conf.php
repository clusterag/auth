<?php
$root = getcwd() . "/";
$login_template_path = $root . "auth/login.html";
$logout_template_path = $root . "auth/logout.html";
$dbp = "";  // passwort der Datenbank
$dbp = file_get_contents($root . "dbp");
$error_not_logged_in = "Benutzername oder Passwort sind falsch. Bitte versuchen Sie es erneut.";
$heute = $root . "auth/heute.html";
$morgen = $root .  "auth/morgen.html";
?>