<?php
include "functions.php";

if (login() && is_admin()) {
	if ($_POST["wipe"]){
		users_wipe();
	}
	echo(make_html(True, "Sind Sie wirklich sicher, dass sie ALLE Sch&uuml;erbenutzer l&ouml;schen wollen?" . file_get_contents($wipe_template_path)));
}


?>
