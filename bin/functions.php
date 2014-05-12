<?php 

$conf = "/kunden/homepages/34/d446716986/htdocs/vertretungsplan_backend/auth/conf.php";
include $conf;

//TODO:
//maybe define database parameters as globals?
//define and ENFORCE guideline for escaping SQL queries.

//GUIDELINES:


function insert_into_str($string, $place, $insert){
	$around = explode($place, $string);
	return $around[0] . $insert . $around[1];
}

function build_link($text, $href, $class="", $id=""){
	$link = "<a href=\"" . $href . "\" ";
	if ($class){
		$link = $link . "class=\"" . $class . "\" ";
	}
	if ($id){
		$link = $link . "id=\"" . $id . "\" ";
	}
	$link = $link . ">" . $text . "</a>";

	return $link;
}

function build_ul_item($text, $class="", $id = ""){
	$item = "<li " ;
	if ($class){
		$item = $item . "class=\"" . $class . "\"";
	}
	if ($id){
		$item = $item . " id=\"" . $id . "\"";
		}
	$item = $item . ">" . $text . "</li>";
	return $item;
}

function build_ul($items, $class="", $id=""){
	$header = "<ul ";
	if ($class){
		$header = $header . "class=\"" . $class . "\" ";
	}
	if ($id){
		$header = $header . "id=\"" . $id . "\" ";
	}
	$header = $header . ">";

	foreach ($items as $item) {
		$header = $header . $item;
	}
	$header = $header . "</ul>";
	return $header;
}

function build_header_item($text, $class, $align){
	return build_ul_item($text, $class, $align);
}

function make_html($logged_in, $content=""){
	global $template_path;
	$template = file_get_contents($template_path);
	$header_left = "";
	$header_right = "";
	$username = $_SESSION["username"];

	$template = insert_into_str($template, "<!--CONTENT-->", $content);

	if ($logged_in && is_admin() ){		
		$header_left = build_header_item(build_link("Heute", "heute.php"), "mainnavitem", "left") . build_header_item(build_link("Morgen", "morgen.php"), "mainnavitem", "left");
		$header_right = build_header_item($username, "mainnavitem", "right") . build_header_item(build_link("Benutzerverwaltung", "admin.php"), "mainnavitem", "right") . build_header_item(build_link("Passwort ändern", "settings.php"), "mainnavitem", "right") . build_header_item(build_link("Abmelden", "logout.php"), "mainnavitem", "right");
	}
	elseif ($logged_in) {
		$header_left = build_header_item(build_link("Heute", "heute.php"), "mainnavitem", "left") . build_header_item(build_link("Morgen", "morgen.php"), "mainnavitem", "left");
		$header_right = build_header_item($username, "mainnavitem", "right") . build_header_item(build_link("Passwort ändern", "settings.php"), "mainnavitem", "right") . build_header_item(build_link("Abmelden", "logout.php"), "mainnavitem", "right");
	}

	if ($header_left){
		$template = insert_into_str($template, "<!--HEADER_LEFT-->", $header_left);
	}

	if ($header_right){
		$template = insert_into_str($template, "<!--HEADER_RIGHT-->", $header_right);
	}

	return $template;
}

//database functions

//hopefully we won't be needing these parameters
//function db_connect($db_host, $db_user, $db_password, $db_database){
function db_connect(){
	global $db_host;
	global $db_user;
	global $db_password;
	global $db_database;
	$database = new mysqli($db_host, $db_user, $db_password, $db_database);
	if ($database->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $databse->connect_errno . ") " . $database->connect_error;
	}
	return $database;
}

function db_get_field($database, $table, $get_field, $where_field, $where_value){
	//escape $where_value. all other parameters are not user defined.
	$where_value = $database->real_escape_string($where_value);
	$query = "SELECT " . $get_field . " FROM " . $table . " WHERE " . $where_field . " = '" . $where_value . "'";
	$get_value = mysqli_fetch_assoc($database->query($query))[$get_field];
	//if (!$get_value){
	//	echo "Table creation failed: (" . $database->errno . ") " . $database->error;
	//}
	return $get_value;
}

function db_set_field($database, $table, $set_field, $set_value, $where_field, $where_value){
	//WARNING: THIS FUNCTION DOES NOT RETURN ERRORS
	//escape $where_value.
	$where_value = $database->real_escape_string($where_value);
	$set_value = $database->real_escape_string($set_value);
	$query = "UPDATE " . $table . " SET " . $set_field . " = '" . $set_value . "' WHERE " . $where_field . " = '" . $where_value . "'";
	$database->query($query);
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

function set_teacher($username, $is_teacher){
	$database = db_connect();
	if ($is_teacher) {
		db_set_field($database, "users", "teacher", "2", "UID", $username);
	}
	else {
		db_set_field($database, "users", "teacher", "1", "UID", $username);
	}
}

function is_admin(){
	$username = $_SESSION["username"];
	$database = db_connect();
	if (db_get_field($database, "users", "admin", "UID", $username) == "2"){
		return True;
	}
	else {
		return False;
	}
}

function is_user($username){
	$database = db_connect();
	
	//DOESN'T WORK
	//if (db_get_field($database, "users", "*", "UID", $username)){
	//	echo db_get_field($database, "users", "*", "UID", $username);
	//	return True;
	//}
	//else {
	//	return False;
	//}

	// this always returns True
	// SELECT * FROM `users` WHERE `UID`='$username';
	//$query = "SELECT * FROM `users` WHERE `UID`='" . $username . "';";
	$query = "SELECT 1 FROM 'table' WHERE 'UID' = '" . $username . "';";
	echo ($database->num_rows($database->query($query)));
	//if (){
	//	return True;
	//}
	//else{
	//	return False;
	//}
}

function add_user($username, $password, $is_teacher){
	$database = db_connect();
	$hash = password_hash($password, PASSWORD_BCRYPT);

	if ($is_teacher){
		$teacher = "2";
	}
	else {
		$teacher = "1";
	}
	$query = "INSERT INTO `users` ( `UID` , `PW` , `teacher` , `admin` ) VALUES ( '" . $username . "', '" . $hash . "', '" . $teacher . "', '1' );";
	$database->query($query);
}

function del_user($username){
	$database = db_connect();
	$query = "DELETE FROM `users` WHERE `UID` = '" . $username . "'";
	$database->query($query);
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


function login(){
	//checks if the session is logged in
	//if it is not, gets POST params and checks password
	//if password is wrong or none given echoes login template
	global $login_template_path;
	global $error_not_logged_in;
	$login_template = file_get_contents($login_template_path);

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
				echo(make_html(False, $error_not_logged_in . $login_template));
				return False;
			};
		}
		//if no username has been posted, i.e. user has not tried to login yet
		else {
			echo(make_html(False, $login_template));
			return False;
			
		};
	};
}

 ?>
