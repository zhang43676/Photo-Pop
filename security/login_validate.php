<?php
require_once("../support/execute_sql.php");
require_once("../redirection.php");
?>

<html>
<body>
    <?php
	     
    if (isset ($_POST['login'])){
		//get the input
		$username=$_POST['username'];
		$password=$_POST['password'];
				 
		//sql command
		$sql = 'SELECT password FROM users WHERE user_name = \''.$username.'\' ';
		$results = get_sql_results($sql);
			 
		//validate 
		$valid_user = false;
		$valid_pass = false;
		foreach ($results as $item) {
				$valid_user = true;
				$item = array_shift($item);
	
				if ($item == $password) {
					$valid_pass = true;
				}
		}
	     
	    $redirect = "Location: ".$url['login'];
	    if (!$valid_user) {
		    header($redirect."?error=username");
	    }  else if (!$valid_pass) {
		    header($redirect."?error=password");
	    } else {
			//set user cookier
			setcookie("username", $username, time()+60*60*3, "/");
			//redirect user accordingly
			if ($username == "admin") {
				header("Location: ".$url["view_all"]);
			} else {
				header("Location: ".$url["view_limited"]);
			}
	    }
	     
    } else if (isset ($_POST['signup'])){
	    header("Location: ".$url["registration_main"]);
    }
    ?>
</body>
</html>
