<?php
include "functions.php";

if (login() && is_admin()) {

	echo(make_html(True, file_get_contents($teachers_template_path) . get_user_list(True)));

}


?>
