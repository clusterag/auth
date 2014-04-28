<?php 

$conf = "/kunden/homepages/34/d446716986/htdocs/vertretungsplan_backend/conf.php";
include $conf;

//TODO:
//maybe define database parameters as globals?
//define and ENFORCE guideline for escaping SQL queries.

//GUIDELINES:


global $root;
global $login_template_path;
global $logout_template_path;
global $admin_template_path;
global $db_host;
global $db_user;
global $db_password;
global $db_database;
global $error_not_logged_in;
global $heute;
global $morgen;

echo strlen($db_host);

//database functions

//hopefully we won't be needing these parameters
//function db_connect($db_host, $db_user, $db_password, $db_database){
function db_connect(){
	$database = new mysqli($db_host, $db_user, $db_password, $db_database);
	echo $db_host;
	return $database;
}

function db_get_field($database, $table, $get_field, $where_field, $where_value){
	//escape $where_value. all other parameters are not user defined.
	$where_value = $database->real_escape_string($where_value);
	$query = "SELECT " . get_field . " FROM" . $table . " WHERE " . $where_field . " = '" . $where_value . "'";
	$get_value = mysqli_fetch_assoc($database->query($query))[$get_field];
	return $get_value;
}

function db_set_field($database, $table, $set_field, $set_value, $where_field, $where_value){
	//WARNING: THIS FUNCTION DOES NOT RETURN ERRORS
	//escape $where_value.
	$where_value = $database->real_escape_string($where_value);
	$set_value = $database->real_escape_string($set_value);
	$query = "UPDATE " . $table . " SET " . set_field . " = '" . $set_value . "' WHERE " . $where_field . " = '" . $where_value . "'";
}

function set_pw_hash($username, $hash){
	$database = db_connect();
	db_set_field($database, "users", "PW", $hash, "UID", $username);
}

function get_pw_hash($username){
	$database = db_connect();
	$hash = db_get_field($database, "users", "PW", "UID", $username);
	return $hash;
}

function set_password($username, $password){
	set_pw_hash($username, password_hash($password, PASSWORD_BCRYPT));
}



function session_logged_in(){
	if ($_SESSION["logged_in"] == 1){
		return True;
	}
	else {
		return False;
	}
}

//hopefully we won't be needing all these parameters anymore
//function check_password($username, $password, $db_host, $db_user, $db_password, $db_database, $table){
function check_password($username, $password){
	//all this should be replaced by new function get_pw_hash
	//$database = new mysqli($db_host, $db_user, $db_password, $db_database);  //connect to database
	//$hash_query = "SELECT PW FROM " . $table . " WHERE UID = '" . $username . "'";
	//$hash = mysqli_fetch_assoc($database->query($hash_query))["PW"];

	$hash = get_pw_hash($username);
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
		//if a username has been posted, i.e. user is trying to login
		if (isset($_POST["username"])) {
			//checking password
			//if password is correct, set username in session to username, return true
			//hopefully we won't be needing all these parameters anymore
			//if(check_password($username, $password, $db_host, $db_user, $db_password, $db_database, $table)){
			if(check_password($username, $password)){
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
