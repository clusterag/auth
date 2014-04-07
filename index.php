<?php
//CONF
$root = "/kunden/homepages/34/d446716986/htdocs/vertretungsplan_backend/";
$login_template_path = $root . "auth/login.html";
$logout_template_path = $root . "auth/logout.html";
#$dbp = "";  // passwort der Datenbank
$dbp = file_get_contents($root . "dbp");
echo ($dbp);
$error_not_logged_in = "Benutzername oder Passwort sind falsch. Bitte versuchen Sie es erneut.";
$heute = $root . "auth/heute.html";
$morgen = $root .  "auth/morgen.html";

function session_logged_in(){
	if ($_SESSION["logged_in"] == 1){
		return True;
	}
	else {
		return False;
	}
}

function check_password($username, $password, $dbp){
	$database = new mysqli("db521844234.db.1and1.com", "dbo521844234", $dbp, "db521844234" );  //connect to database
	$hash_query = "SELECT PW FROM users WHERE UID = '" . $username . "'";
	$hash = mysqli_fetch_assoc($database->query($hash_query))["PW"];
	$logged_in = password_verify($password, $hash);
	return $logged_in;
}

function login($login_template_path, $error_not_logged_in, $dbp){
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
		if (isset($_POST["username"])) {
			//checking password
			//if password is correct, set username in session to username, return true
			if(check_password($username, $password, $dbp)){
				$_SESSION["username"] = $username;
				$_SESSION["logged_in"] = 1;
				return True;
			}
			else {
				echo($error_not_logged_in);
				echo($login_template);
				return False;
			};
		}
		//if no username has been posted, i.e. user has not tried to login yet
		else {
			echo($login_template);
			return False;
			
		};
	};
}

//login must be the first function called because it sets the session cookie which must be done before the http body starts
if (login($login_template_path, $error_not_logged_in, $dbp)) {
	if($_GET["pid"] == 1){
		echo (file_get_contents($morgen));
	}
	else {
		echo (file_get_contents($heute));
	};
	echo(file_get_contents($logout_template_path));
};

?>
