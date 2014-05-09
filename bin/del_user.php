<?php
//CONF
include "functions.php";

if (login()) {
		echo (make_html(True, file_get_contents($delete_user_template_path)));
};
?>