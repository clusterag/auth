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

function session_logged_in(){
	if (isset($SESSION["username")]){
		return True;
	}
	else {
		return False;
	}
}

function check_password($username, $password){
	$database = new mysqli("db521844234.db.1and1.com", "dbo521844234", $dbp, "db521844234" );  //connect to database
	$hash_query = "SELECT PW FROM users WHERE UID = '" . $username . "'";
	// echo($hash_query);
	$hash = mysqli_fetch_assoc($database->query($hash_query))["PW"];
	//AFAIK, storing boolean in cookies is not advisable
	$logged_in = password_verify($password, $hash);
	return $logged_in;
}

function check_login(){
	//checks if the session is logged in
	//if it is not, gets POST params and checks password
	//if password is wrong or none given echoes login template

	session_set_cookie_params(300);
	session_start();
	//if session is logged in return True
	if(session_logged_in()){
		return True;
	}
	//if session is not logged in
	else {
		//getting POST parameters
		$username = $_POST["username"];  //Benutzer
		$password = $_POST["password"];  //Passwort
		$login_template = file_get_contents($login_template_path);
		
		//if a username has been posted, i.e. user is trying to login
		if (isset($username)) {
			//checking password
			//if password is correct, set username in session to username, return true
			if(check_password($username, $password)){
				$_SESSION["username"] = $username;
				return True;
			}
			else {
				return False;
				echo($error_not_logged_in);
				echo($login_template);
			};
		}
		
		//if no username has been posted, i.e. user has not tried to login yet
		else {
			return False;
			echo($login_template);
		};
	};
}
//check_login must be the first function called because it sets the session cookie which must be done before the http body starts
if (check_login()) {
	#echo (file_get_contents($heute));
	echo("success");
};

?>
