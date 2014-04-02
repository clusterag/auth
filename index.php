<?php

$username = $_POST["username"];  //Benutzer
$password = $_POST["password"];  //Passwort

$dbp = "sGN59LNdKJJScrTK";  // passwort der Datenbank

$database = new mysqli("db521844234.db.1and1.com", "dbo521844234", $dbp, "db521844234" );  //connect to database

$hash_query = "SELECT PW FROM users WHERE UID =".$username;
$hash = $database->query($hash_query);

$logged_in = password_verify($password, $hash);

if $logged_in = True (
	//redirect
	echo "True";
)

?>