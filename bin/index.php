<?php
//CONF
include "functions.php";

//login must be the first function called because it sets the session cookie which must be done before the http body starts
if (login() && $_SERVER["REQUEST_URI"] != "admin.php") {
	if ($_GET["pid"] == 1){
		echo (make_html(True, file_get_contents($morgen));
	}
	else {
	echo(make_html(True, file_get_contents($heute)));
	};
};


?>
