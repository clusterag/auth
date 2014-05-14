<?php
include "functions.php";

if (login() && is_admin()) {

	echo(make_html(True, get_user_list(True)));

}


?>
