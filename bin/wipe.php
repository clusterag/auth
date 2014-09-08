<?php
include "functions.php";

if (login() && is_admin()) {
	if ($_POST["wipe"]){
		users_wipe();
	}
	echo(make_html(True, file_get_contents($wipe_template_path)));
}


?>
