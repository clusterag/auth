<?php
include "functions.php";

//TWO versions of this file:
//1. botched calculations of the username
//2. getting username from user input
//currently using #2
//In the future might attempt calculation again, or leave it to auth-utils.

//#1
//	//getting POST parameters
//	$firstname = $_POST["firstname"];
//	$lastname = $_POST["lastname"];
//	$dob = $_POST["dob"];  //DayOfBirth
//	$mob = $_POST["mob"];  //MonthOfBirth
//	$yob = $_POST["yob"];  //YearOfBirth
//	
//	$date = strtotime($yob . "-" . $mob . "-" . $dob);
//	echo("year". $yob . "month" . $mob . "day" . $dob . "  ");
//	//$diff = strtotime("1899-12-30");
//	//echo $diff . "++";
//	echo $date;
//	$datediff = ($date - 2209168800) / (86400);
//	echo $datediff;
//	
//	if (login() && is_admin()) {
//		if ($_POST["firstname"] && $_POST["lastname"] && $_POST["dob"] && $_POST["mob"] &&$_POST["yob"]){
//			$date = strtotime($yob . "-" . $mob . "-" . $dob);
//			add_user($_POST["username"], $_POST["password"], $teacher);
//			echo(make_html(True, "Benutzer \"" . $_POST["username"] . "\" wurde erstellt" . file_get_contents($add_user_template_path)));
//		}
//		elseif ($_POST["username"]) {
//			echo(make_html(True, "Bitte geben sie ein Passwort ein. " . file_get_contents($add_user_template_path)));
//		}
//		else {
//			echo(make_html(True, file_get_contents($add_user_template_path)));
//		}
//		
//	
//	}

//#2
if (login() && is_admin()) {
	if ($_POST["username"] && $_POST["password"]){
		add_user($_POST["username"], $_POST["password"], False);
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