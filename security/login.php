<link rel = "stylesheet" type = "text/CSS" href="../login.css" />

<html>
<body>

<?php
	if (isset($_COOKIE["username"])) {
		// Clear the cookie, as user is redirected here
		// if they log out
		setcookie ("username", "", time() - 3600, "/");
		unset($_COOKIE["username"]);
	}
?>


<div>

<h1>Welcome to PhotoPop!</h1>
<FONT COLOR="FF0000">
<?php
	if ($_GET["error"]) {
		echo 'Invalid ' . htmlspecialchars($_GET["error"]) . '!';
	} 
?>
</FONT>

<FONT COLOR="008000">
<?php
	if ($_GET["username"]) {
		echo $_GET["username"].", you are now registered. Thank you! Login.";
	}
?>
</FONT>


<form action="login_validate.php" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<input type="submit" name="login" value="Login"/>
<input type="submit" name="signup" value="Sign up"/>
</form>

</div>

</body>
</html> 
