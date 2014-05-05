<?php
include "functions.php";

if (login()) {
	echo(file_get_contents($admin_template_path));

}


?>