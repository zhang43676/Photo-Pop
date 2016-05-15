<?php
    require_once("../support/execute_sql.php");
    require_once("welcome_main.php");
    
    session_start();
?>

<link rel = "stylesheet" type = "text/CSS" href="../login.css" />

<html>
    <body>
        <h1>Change Settings</h1>
		
		
		<?php
            
            if (isset($_SESSION["validate_errors"]) && $_SESSION["validate_errors"]) {
				echo '<FONT COLOR="FF0000">';
				echo $_SESSION["validate_errors"];
                unset($_SESSION["validate_errors"]);
				echo '</FONT>';
			} else if ($_GET["updated"]) {
				echo '<FONT COLOR="008000">';
				echo 'Settings updated.<br><br>';
				echo '</FONT>';
			}
            session_write_close();
		?>
		
				
        
		
			<?php
            $username = $_COOKIE["username"];
            
            $person_details = "SELECT first_name,last_name,address,email,phone from PERSONS where user_name = '".$username."'";
            $person_details = array_shift(get_sql_results($person_details));
            $first_name = array_shift($person_details);
            $last_name = array_shift($person_details);
            $address = array_shift($person_details);
            $email = array_shift($person_details);
            $phone = array_shift($person_details);
            
			$user_details = "SELECT date_registered from USERS where user_name = '".$username."'";
            $user_details = array_shift(get_sql_results($user_details));
            $date = array_shift($user_details);
            
            echo "$username, you registered on  $date. <br>";
              
            echo '<form method="post" action="registration_validate.php">';
            echo '<br>New PassWord : <input type = "password" name = "Password"';
			echo ' /><br/>';
            echo 'Re-type PassWord : <input type = "password" name = "rePassword"';
			echo ' /><br/>';
            echo '<input type="submit" name="change_pass" value="Change Password"/>';
			echo '</form>';
            
            echo '<form method="post" action="registration_validate.php">';
            echo '<br>First Name: '. $first_name .' <br><input type="text" name="first_name"/>';
            echo '<input type="submit" name="change_first" value="Change First Name"/>';
			echo ' <br/>';
            echo '</form>';
			
            echo '<form method="post" action="registration_validate.php">';
            echo '<br>Last Name: '. $last_name .'<br><input type="text" name="last_name"/>';
            echo '<input type="submit" name="change_last" value="Change Last Name"/>';
			echo ' <br/>';
            echo '</form>';
            
			echo '<form method="post" action="registration_validate.php">';
            echo '<br>Phone Number: '. $phone .'<br><input type = "text" name ="phone_number"/>';
            echo '<input type="submit" name="change_phone" value="Change Phone"/>';
			echo ' <br/>';
            echo '</form>';
			
            echo '<form method="post" action="registration_validate.php">';
            echo '<br>Email: '. $email .'<br><input type ="text" name = "email"/>';
			echo '<input type="submit" name="change_email" value="Change Email"/>';
			echo ' <br/>';
            echo '</form>';
			
            echo '<form method="post" action="registration_validate.php">';
            echo '<br>Address: '. $address .'<br><input type = "text" name = "address"/>';
            echo '<input type="submit" name="change_addr" value="Change Address"/>';
			echo ' <br/>';
            echo '</form>';
			
			?>
        
    </body>
</html>