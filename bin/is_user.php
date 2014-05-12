<form name="is_user" id="is_user" action="is_user.php" method="post" >

<div id="username">
	<p>Benutzername:</p>
	<input type="text" name="username" value="" >
</div>

<div id="submit">
	<input type="submit" value="Benutzer aktualisieren">
</div>

</form>
<?php 
include "functions.php";
if (is_user($_POST["username"])){
	echo "success";
}
else {
	echo "failure";
}
?>