<?php
//CONF
include "functions.php";

//login must be the first function called because it sets the session cookie which must be done before the http body starts
if (login()) {
	if ($disable_python) {
		echo (make_html(True, file_get_contents($heute_raw)));
	}
	else {
		echo (make_html(True, file_get_contents($heute)));
	}
};


?>
