<?php
//CONF
$conf = "/kunden/homepages/34/d446716986/htdocs/vertretungsplan_backend/conf.php";
include $conf;
include "functions.php";

//login must be the first function called because it sets the session cookie which must be done before the http body starts
if (login() && $_SERVER["REQUEST_URI"] != "/auth/admin.php") {
	if($_GET["pid"] == 1){
		echo (file_get_contents($morgen));
		echo $morgen;
	}
	else {
		echo (file_get_contents($heute));
	};
	echo(file_get_contents($logout_template_path));
};


?>
