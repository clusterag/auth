<?php
include "functions.php";
if (login() && is_admin()) {
	echo(make_html(True, file_get_contents($admin_template_path)));
}
?>
