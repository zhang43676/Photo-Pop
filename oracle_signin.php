<link rel = "stylesheet" type = "text/CSS" href="login.css" />

<html>
<body>
	<div>
		
        <form method="post" action="oracle_signin.php">
		<h1>Enter PHP Server Host</h1>
		CCID :	<input type="text" name="ccid"/> <br/>
		 <h1>Login to your Oracle</h1>
            Username :	<input type="text" name="username"/> <br/>
            Password :	<input type="password" name="password"/><br/>
            <input type="submit" name="validate" value="Sign In"/>
			<p> If you are not redirected to the login page after signing in, your username/password was incorrect.</p>
        </form>
	</div>
</body>
</html>

<?php

include("support/PHPconnectionDB.php");

if(isset($_POST['validate'])){        	
	setcookie("ccid", $_POST['ccid']);
	setcookie("oracle_username", $_POST['username']);
	setcookie("oracle_password", $_POST['password']);
	
	// allow us to access these cookies immediately:
	$_COOKIE['oracle_username'] = $_POST['username'];
	$_COOKIE['oracle_password'] = $_POST['password'] ;
	//atempt to connect
	$conn = connect();
	if ($conn) {
		header("Location: http://clive.cs.ualberta.ca/~".$_POST['ccid']."/security/login.php");
	}
}

?>
