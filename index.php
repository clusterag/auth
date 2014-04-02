<?php
//CONF
$root = "/kunden/homepages/34/d446716986/htdocs/vertretungsplan_backend/";
$login_template_path = $root . "auth/login.html";
$dbp = "sGN59LNdKJJScrTK";  // passwort der Datenbank
$error_not_logged_in = "Benutzername oder Passwort sind falsch. Bitte versuchen Sie es erneut.";
$heute = $root . "output/heute.html";
$morgen = $root .  "output/morgen.html";

//if ($_SESSION["logged_in"]){
//	if ($_GET["pid"] == "0" ) {
//		echo (file_get_contents($heute));
//	}
//
//	elseif ($_GET["pid"]) == "1" ) {
//		echo (file_get_contents($morgen));
//	};
//};

session_start();

$login_template = file_get_contents($login_template_path);
$username = $_POST["username"];  //Benutzer
$password = $_POST["password"];  //Passwort

//if a username has been posted, i.e. user is trying to login
if (isset($username)) {
	echo($error_not_logged_in);
	echo($login_template);
}
//if no username has been posted, i.e. user has not tried to login yet
else {
	echo($login_template);
}


$database = new mysqli("db521844234.db.1and1.com", "dbo521844234", $dbp, "db521844234" );  //connect to database

$hash_query = "SELECT PW FROM users WHERE UID = '" . $username . "'";
// echo($hash_query);
$hash = mysqli_fetch_assoc($database->query($hash_query))["PW"];


$_SESSION["logged_in"] = password_verify($password, $hash);

if ($_SESSION["logged_in"]) {
	HttpResponse::redirect("index.php", array("pid" => "0"), true);
}
else {
	echo("False");
}

?>