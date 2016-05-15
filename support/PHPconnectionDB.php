<?php

function connect(){

	$conn = oci_connect($_COOKIE['oracle_username'], $_COOKIE['oracle_password']);
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	return $conn;
}
?>

