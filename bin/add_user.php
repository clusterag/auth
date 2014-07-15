<?php
include "functions.php";

//getting POST parameters
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$dob = $_POST["dob"];  //DayOfBirth
$mob = $_POST["mob"];  //MonthOfBirth
$yob = $_POST["yob"];  //YearOfBirth

$date = strtotime($yob . "-" . $mob . "-" . $dob);
$diff = strtotime("1899-12-30");
echo $diff . "++";
$datediff = ($date - 2209161600) / 24 / 60 / 60;
echo $datediff;

if (login() && is_admin()) {
	if ($_POST["firstname"] && $_POST["lastname"] && $_POST["dob"] && $_POST["mob"] &&$_POST["yob"]){
		$date = strtotime($yob . "-" . $mob . "-" . $dob);
		add_user($_POST["username"], $_POST["password"], $teacher);
		echo(make_html(True, "Benutzer \"" . $_POST["username"] . "\" wurde erstellt" . file_get_contents($add_user_template_path)));
	}
	elseif ($_POST["username"]) {
		echo(make_html(True, "Bitte geben sie ein Passwort ein. " . file_get_contents($add_user_template_path)));
	}
	else {
		echo(make_html(True, file_get_contents($add_user_template_path)));
	}
	

}


?>