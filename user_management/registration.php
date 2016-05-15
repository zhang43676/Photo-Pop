<?php
	session_start();
?>

<link rel = "stylesheet" type = "text/CSS" href="../login.css" />

<html>
    <body>
        <h1>Welcome to PhotoPop</h1>
		
		<FONT COLOR="FF0000">
		<?php
			if (isset($_SESSION["validate_errors"]) && $_SESSION["validate_errors"]) {
				echo $_SESSION["validate_errors"];
			} 
		?>
		</FONT>
				
        <form name="registration" method="post" action="registration_validate.php">
		
			<?php

            echo 'User Name : <input type = "text" name = "username"';
			if (isset($_SESSION["username"]) && $_SESSION["username"] ) {
				echo ' value='.$_SESSION["username"];
			}
			echo ' /><br/>';
			
            echo 'PassWord : <input type = "password" name = "Password"';
			echo ' /><br/>';
            echo 'Re-type PassWord : <input type = "password" name = "rePassword"';
			echo ' /><br/>';
			
            echo 'First Name : <input type="text" name="first_name"';
			if (isset($_SESSION["first_name"]) && $_SESSION["first_name"]) {
				echo ' value='.$_SESSION["first_name"];
			}
			echo ' /><br/>';
			
            echo 'Last Name : <input type="text" name="last_name"';
			if (isset($_SESSION["last_name"]) && $_SESSION["last_name"]) {
				echo ' value='.$_SESSION["last_name"];
			}
			echo ' /><br/>';
			
            echo 'Phone Number : <input type = "number" name ="phone_number"';
			if (isset($_SESSION["phone_number"]) && $_SESSION["phone_number"]) {
				echo ' value='.$_SESSION["phone_number"];
			}
			echo ' /><br/>';
			
            echo 'Email: <input type ="text" name = "email"';
			if (isset($_SESSION["email"]) && $_SESSION["email"]) {
				echo ' value='.$_SESSION["email"];
			}
			echo ' /><br/>';
			
            echo 'Address : <input type = "text" name = "address"';
			if (isset($_SESSION["address"]) && $_SESSION["address"]) {
				echo ' value='.$_SESSION["address"];
			}
			echo ' /><br/>';

			unset($_SESSION["username"]);
			unset($_SESSION["first_name"]);
			unset($_SESSION["last_name"]);
			unset($_SESSION["phone_number"]);
			unset($_SESSION["email"]);
			unset($_SESSION["address"]);
			unset($_SESSION["validate_errors"]);
			
            echo '<input type="submit" name="validate" value="Submit"/>';
			echo '<input type="reset" name="reset_all" value="Reset"/>';
			?>
        </form>
    </body>
</html>

