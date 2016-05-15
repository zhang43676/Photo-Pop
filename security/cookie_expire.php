<?php
require_once("../redirection.php");

if (isset($_COOKIE["username"]) == false) {
	header("Location: " . $url["login"]. "?error=session, please re-login");	
} 

?>
