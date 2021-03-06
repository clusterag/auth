<?php 
//THIS FILE CONTAINS:
//all PHP functions used in the auth project
//TODO: change configuration to be an array with string keys, make it accessible from every function (superglobal?)

//import configuration from conf.php
$conf = "/kunden/homepages/34/d446716986/htdocs/vertretungsplan_backend/auth/conf.php";
include $conf;
//possibly never used
//generates a password 8 chars long, only hex digits.
function gen_passwd(){
	$password = "";
	$letters = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F");
	for ($i=0; $i < 7; $i++) { 
		$password = $password . $letters[array_rand($letters)];
	}
	return $password;
}

//insert $insert into $string at $place
function insert_into_str($string, $place, $insert){
	$around = explode($place, $string);
	$return = $around[0] . $insert;
	for ($i=1; $i < count($around); $i++) { 
		$return = $return . $around[$i];
	}
	return $return;
}

//HTML functions

//build an HTML <a> element 
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

//build an HTML <li> element
//TODO: rename to build_li
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

//build an HTML <ul> block from an array containing <li> elements
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

//TODO: remove this cleanly
function build_header_item($text, $class, $align){
	return build_ul_item($text, $class, $align);
}

//build the HTML that is given out to the user
function make_html($logged_in, $content=""){\
	//getting $template_path from conf
	global $template_path;
	//reading the template file
	$template = file_get_contents($template_path);
	$header_left = "";
	$header_right = "";
	//getting username from session
	$username = $_SESSION["username"];
	//inserting $content into the template
	$template = insert_into_str($template, "<!--CONTENT-->", $content);
	//build the header with the link "Benutzerverwaltung" for admins...
	if ($logged_in && is_admin() ){		
		$header_left = build_header_item(build_link("Heute", "heute"), "mainnavitem", "left") . build_header_item(build_link("Morgen", "morgen"), "mainnavitem", "left");
		$header_right = build_header_item(get_user_full_name($username), "mainnavitem", "right") . build_header_item(build_link("Benutzerverwaltung", "admin"), "mainnavitem", "right") . build_header_item(build_link("Passwort ändern", "settings"), "mainnavitem", "right") . build_header_item(build_link("Abmelden", "logout"), "mainnavitem", "right");
	}
	//... and without it for regular users
	elseif ($logged_in) {
		$header_left = build_header_item(build_link("Heute", "heute"), "mainnavitem", "left") . build_header_item(build_link("Morgen", "morgen"), "mainnavitem", "left");
		$header_right = build_header_item(get_user_full_name($username), "mainnavitem", "right") . build_header_item(build_link("Passwort ändern", "settings"), "mainnavitem", "right") . build_header_item(build_link("Abmelden", "logout"), "mainnavitem", "right");
	}
	//TODO:revamp this
	//currently it will never run, probably a relict from an older code version, need to see if it's still being used.
	if ($header_left){
		$template = insert_into_str($template, "<!--HEADER_LEFT-->", $header_left);
	}

	if ($header_right){
		$template = insert_into_str($template, "<!--HEADER_RIGHT-->", $header_right);
	}

	return $template;
}

//database functions

//create the connection to the database
function db_connect(){
	global $db_host;
	global $db_user;
	global $db_password;
	global $db_database;
	$database = new mysqli($db_host, $db_user, $db_password, $db_database);
	if ($database->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $databse->connect_errno . ") " . $database->connect_error;
	}
	$database->set_charset("utf8");
	return $database;
}

//get a field from the database
function db_get_field($database, $table, $get_field, $where_field, $where_value){
	//escape $where_value. all other parameters are not user defined.
	$where_value = $database->real_escape_string($where_value);
	$query = "SELECT " . $get_field . " FROM " . $table . " WHERE " . $where_field . " = '" . $where_value . "'";
	if ($get_field == "*"){
		$get_value = mysqli_fetch_assoc($database->query($query));
	}
	else {
		$get_value = mysqli_fetch_assoc($database->query($query))[$get_field];
	}
	return $get_value;
}

//TODO:error handling
//set a field in the database
function db_set_field($database, $table, $set_field, $set_value, $where_field, $where_value){
	//WARNING: THIS FUNCTION DOES NOT RETURN ERRORS
	//escape $where_value.
	$where_value = $database->real_escape_string($where_value);
	$set_value = $database->real_escape_string($set_value);
	$query = "UPDATE " . $table . " SET " . $set_field . " = '" . $set_value . "' WHERE " . $where_field . " = '" . $where_value . "'";
	$database->query($query);
}

//TODO:rename this to students_wipe
//delete all students
function users_wipe(){
	$database = db_connect();
	$query = "DELETE FROM users WHERE class != ''";
	$database->query($query);
}

//TODO: discuss: is this really neccessary? extra step of creating new admin in the database might be beneficial
//for security reasons as well as to prevent an unneccessary influx of admins
//make a user an admin
function make_admin($username, $add){
	$database = db_connect();
	if ($add){
		db_set_field($database, "users", "admin", "2", "UID", $username);
	}
	else {
		db_set_field($database, "users", "admin", "1", "UID", $username);
	}
	
}

//TODO: think about that semicolon in the last line really hard and get rid of it
//(not possible right now because I'm not sure if this code is running live)
//get a users full name
function get_user_full_name($username){
	$database = db_connect();
	$firstname = db_get_field($database, "users", "firstname", "UID", $username);
	$lastname = db_get_field($database, "users", "lastname", "UID", $username);
	return $firstname . " " . $lastname;
	;
}

//TODO: come up with a better name, maybe think about the implementation
//generates the links "Passwort aendern" and "Aendern"
function show_user_link($username, $parameter, $password = False){
	if ($password){
		return "<form name=\"change_user\" id=\"change_user\" action=\"change_user\" method=\"post\" ><input type=\"hidden\" name=\"parameter\" value=\"" . $parameter . "\" ><input type=\"hidden\" name=\"username\" value=\"" . $username . "\" ><input type=\"submit\" value=\"Passwort &auml;ndern\"></form>";
	}
	else {
		return "<form name=\"change_user\" id=\"change_user\" action=\"change_user\" method=\"post\" ><input type=\"hidden\" name=\"parameter\" value=\"" . $parameter . "\" ><input type=\"hidden\" name=\"username\" value=\"" . $username . "\" ><input type=\"submit\" value=\"&Auml;ndern\"></form>";
	}
	
}

//TODO:check if user exists properly (does not work)
//show a users details
function show_user($username){
	//TODO: hide this
	$roots = ["admin", "R00T", "root", "john"];
	if (!in_array($username, $roots)){
		$database = db_connect();
		$row = db_get_field($database, "users", "*", "UID", $username, True);
		$user = "Benutzername:		" . $row["UID"] . "<br/> Vorname:		" . $row["firstname"] . show_user_link($username, "firstname") . "<br/> Nachname:		" . $row["lastname"] . show_user_link($username, "lastname") . "<br/> Klasse:		" . $row["class"] . show_user_link($username, "class");
		if ($row["teacher"] == 2){
			$user = $user . "<br/> Lehrer:		Ja";
		}
		else {
			$user = $user . "<br/> Lehrer:		Nein";
		}
		$user = $user . "<br/>" . show_user_link($username, "password", True);
		return $user;
	}
	else {
		return "Benutzername " . $username . " nicht gefunden.";
	}
}

//generate a list of all users
//flag $teachers=True returns a list of only teachers
function get_user_list($teachers=False){
	$database = db_connect();
	$query = "SELECT * FROM `users`;";
	$result = $database->query($query);
	$users = array();
	$teacher_status = array();
	$roots = ["admin", "R00T", "root", "john"];
	if($teachers){
		$list = "<table>";
	}
	else{
		$list = "<form name=\"make_admin\" id=\"make_admin\" action=\"list\" method=\"post\" ><div id=\"username\"><p>Benutzername:</p><input type=\"text\" name=\"username\" value=\"\" ></div><div id=\"admin\"><p>Adminstatus (1 oder 2):</p><input type=\"text\" name=\"admin\" value=\"\" ></div><div id=\"submit\"><input type=\"submit\" value=\"Status &Auml;ndern\"></div></form><br/><table>";
	}
	

	while ($row = mysqli_fetch_assoc($result)) {
        $username = $row["UID"];
        if(!in_array($username, $roots)){
        	$teacher_status = $row["teacher"];
        	$firstname = $row["firstname"];
        	$lastname = $row["lastname"];
        	$class = $row["class"];
        	
        	if(!$teachers){
        		$list = $list . "<tr><td>" . $username . "</td><td>" . $firstname . "</td><td>" . $lastname . "</td><td>" . $class . "</td><td>";
        		if($teacher_status == "2"){
        			$list = $list . "Lehrer";
        		}
        		else{
        			$list = $list . "Sch&uuml;ler";
        		}
        	}
        	elseif($teachers && $teacher_status == "2"){
        		$list = $list . "<tr><td>" . $username . "</td><td>" . $firstname . "</td><td>" . $lastname . "</td><td>" . "Lehrer";
        	}
        	$list = $list . "</td></tr>";
        }
    }
    $list = $list . "</table>";
	return $list;
}

//set the password hash for the specified user
function set_pw_hash($username, $hash){
	$database = db_connect();
	db_set_field($database, "users", "PW", $hash, "UID", $username);
}

//get a specified user's password hash
function get_pw_hash($username){
	$database = db_connect();
	$hash = db_get_field($database, "users", "PW", "UID", $username);
	return $hash;
}

//set a user's password
//contains encryption
function set_password($username, $password){
	set_pw_hash($username, password_hash($password, PASSWORD_BCRYPT));
}

//set a user to be a teacher
function set_teacher($username, $is_teacher){
	$database = db_connect();
	if ($is_teacher) {
		db_set_field($database, "users", "teacher", "2", "UID", $username);
	}
	else {
		db_set_field($database, "users", "teacher", "1", "UID", $username);
	}
}

//change some aspect of a user
function edit_user($username, $key, $value){
	if ($key != "password"){
		$database = db_connect();
		db_set_field($database, "users", $key, $value, "UID", $username);
	}
	else {
		set_password($username, $value);
	}
}

//generate the form used to modify a user's data
function change_user_template($username, $parameter){
	$translate = array( "password" => "das Passwort",
						"firstname" => "den Vornamen",
						"lastname" => "den Nachnamen",
						"class" => "die Klasse");
	$message = "Sie ver&auml;ndern " . $translate[$parameter] . " f&uuml;r den Benutzer " . $username . ".\n";
	$form = "<form name=\"" . $parameter . "\" id=\"" . $parameter . "\" action=\"change_user\" method=\"post\" ><input type=\"hidden\" name=\"username\" value=\"" . $username . "\" ><input type=\"hidden\" name=\"parameter\" value=\"" . $parameter . "\" > \n <input type=\"text\" name=\"value\" value=\"\" ><input type=\"submit\" value=\"&Auml;ndern\"></form>";
	return $message . $form;
}

//check if the current user is an admin
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

//check if the specified user exists
function is_user($username){
	$database = db_connect();
	// this always returns True
	$query = "SELECT * FROM `users` WHERE `UID`='" . $username . "';";
	$result = $database->query($query);
	if ($result->num_rows == 1){
		return True;
	}
	else{
		return False;
	}
}

//add a user to the database
function add_user($firstname, $lastname, $username, $password, $is_teacher, $class){
	$database = db_connect();
	$hash = password_hash($password, PASSWORD_BCRYPT);

	if ($is_teacher){
		$teacher = "2";
		$query = "INSERT INTO users ( `UID` , `firstname` , `lastname` , `PW` , `teacher` , `admin` ) VALUES ('" . $username . "', '" . $firstname . "', '" . $lastname . "', '" . $hash . "', '" . $teacher . "', '1');";
	}
	else {
		$teacher = "1";
		$query = "INSERT INTO users ( `UID` , `firstname` , `lastname` , `PW` , `teacher` , `admin`, `class` ) VALUES ('" . $username . "', '" . $firstname . "', '" . $lastname . "', '" . $hash . "', '" . $teacher . "', '1', '" . $class . "');";
	}
	
	$database->query($query);
}

//delete a user from the database
function del_user($username){
	$database = db_connect();
	$query = "DELETE FROM `users` WHERE `UID` = '" . $username . "'";
	$database->query($query);
}

//TODO: make this work for first name, class ,etc... as well
//look for a user by  last name
//return a list of users with that (exact!) last name
function search_user($lastname){
	$teachers=False;
	$database = db_connect();
	$query = "SELECT * FROM `users` WHERE `lastname` = '" . $lastname . "'";
	$result = $database->query($query);
	$users = array();
	$teacher_status = array();
	$roots = ["admin", "R00T", "root", "john"];

	$list = "<table>";

	while ($row = mysqli_fetch_assoc($result)) {
        $username = $row["UID"];
        if(!in_array($username, $roots)){
        	$teacher_status = $row["teacher"];
        	$firstname = $row["firstname"];
        	$lastname = $row["lastname"];
        	$class = $row["class"];
        	
        	if(!$teachers){
        		$list = $list . "<tr><td>" . $username . "</td><td>" . $firstname . "</td><td>" . $lastname . "</td><td>" . $class . "</td><td>";
        		if($teacher_status == "2"){
        			$list = $list . "Lehrer";
        		}
        		else{
        			$list = $list . "Sch&uuml;ler";
        		}
        	}
        	elseif($teachers && $teacher_status == "2"){
        		$list = $list . "<tr><td>" . $username . "</td><td>" . $firstname . "</td><td>" . $lastname . "</td><td>" . "Lehrer";
        	}
        	$list = $list . "</td></tr>";
        }
    }
    $list = $list . "</table>";
	return $list;
}

//check if the user is logged in in the session
function session_logged_in(){
	if ($_SESSION["logged_in"] == 1){
		return True;
	}
	else {
		return False;
	}
}

//check if a specified password matches the specified username
function check_password($username, $password){
	$hash = get_pw_hash($username);
	$logged_in = password_verify($password, $hash);
	return $logged_in;
}

//checks if the session is logged in
//if it is not, gets POST params and checks password
//if password is wrong or none given echoes login template
function login(){
	global $login_template_path;
	global $error_not_logged_in;
	global $log_path;
	$login_template = file_get_contents($login_template_path);

	session_set_cookie_params(900);
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
			//if password is correct, set username in session to username, return true, add user to log
			if(check_password($username, $password)){
				$_SESSION["username"] = $username;
				$_SESSION["logged_in"] = 1;
				file_put_contents($log_path, $username . "\t\t\t" . date("Y-m-d H:i:s") . "<br />", FILE_APPEND );
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
