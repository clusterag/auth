<?php

$login_template = file_get_contents("/kunden/homepages/34/d446716986/htdocs/vertretungsplan_backend/auth/login.html");
echo($login_template);

$username = $_POST["username"];  //Benutzer
$password = $_POST["password"];  //Passwort

$dbp = "sGN59LNdKJJScrTK";  // passwort der Datenbank

$database = new mysqli("db521844234.db.1and1.com", "dbo521844234", $dbp, "db521844234" );  //connect to database

$hash_query = "SELECT PW FROM users WHERE UID =".$username;
$hash = $database->query($hash_query);

echo($hash);

$logged_in = password_verify($password, $hash);

if ($logged_in) {
	//redirect
	echo("True");
	echo($logged_in);
}
else {
	echo("False");
}

?>