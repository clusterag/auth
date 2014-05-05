<?php
include "functions.php";

if (login()) {
	echo(make_html(True, file_get_contents($admin_template_path)));

}


?>
