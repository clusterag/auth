<?php
include "functions.php";
if (login()) {
	//deadman switch
	if ($disable_python) {
		echo (make_html(True, file_get_contents($morgen_raw)));
	}
	else {
		echo (make_html(True, file_get_contents($morgen)));
	}
};
?>
