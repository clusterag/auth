<?php
//CONF
$login_template_path = "/kunden/homepages/34/d446716986/htdocs/vertretungsplan_backend/auth/login.html";
$dbp = "sGN59LNdKJJScrTK";  // passwort der Datenbank
$error_not_logged_in = "Benutzername oder Passwort sind falsch. Bitte versuchen Sie es erneut.";

$login_template = file_get_contents($login_template_path);

$username = $_POST["username"];  //Benutzer
$password = $_POST["password"];  //Passwort

if (isset($username)) {
	echo($error_not_logged_in);
	echo($login_template);
}
else {
	echo($login_template);
}







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