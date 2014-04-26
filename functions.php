<?php 
function session_logged_in(){
	if ($_SESSION["logged_in"] == 1){
		return True;
	}
	else {
		return False;
	}
}

function check_password($username, $password, $db_host, $db_user, $db_password, $db_database, $table){
	$database = new mysqli($db_host, $db_user, $db_password, $db_database);  //connect to database
	
	$hash_query = "SELECT PW FROM " . $table . " WHERE UID = '" . $username . "'";
	$hash = mysqli_fetch_assoc($database->query($hash_query))["PW"];
	$logged_in = password_verify($password, $hash);
	return $logged_in;
}

function login($login_template, $error_not_logged_in, $db_host, $db_user, $db_password, $db_database, $table){
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
//		$login_template = file_get_contents($login_template_path);
		//if a username has been posted, i.e. user is trying to login
		if (isset($_POST["username"])) {
			//checking password
			//if password is correct, set username in session to username, return true
			if(check_password($username, $password, $db_host, $db_user, $db_password, $db_database, $table)){
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
 ?>