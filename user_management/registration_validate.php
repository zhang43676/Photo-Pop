<?php
require_once("../support/execute_sql.php");
require_once("../redirection.php");

/******
POST request from registration page
******/	
if (isset($_POST['validate'])) {
	session_start();
	
	$username = $_POST['username'];
	$passw = $_POST['Password'];
	$repassw = $_POST['rePassword'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$phone_number = $_POST['phone_number'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	
	//Create session variables in case
	//user messed up, their input is preserved
	$_SESSION["username"] = $username;
	$_SESSION["first_name"] = $first_name;
	$_SESSION["last_name"] = $last_name;
	$_SESSION["phone_number"] = $phone_number;
	$_SESSION["email"] = $email;
	$_SESSION["address"] = $address;
	
	$error="";
	$error .= check_username($username);
	$error .= check_password($passw, $repassw);
	$error .= check_first($first_name);
	$error .= check_last($last_name);
	$error .= check_phone($phone_number);
	$error .= check_email($email);
	$error .= check_addr($address);

	if (strlen($error) != 0 ) {
		$_SESSION["validate_errors"] = $error;
		header("Location: " .$url["registration_main"]);
		exit();
	}
	
	// if user registration validates, clear out the session variables - not needed
	unset($_SESSION["username"]);
	unset($_SESSION["first_name"]);
	unset($_SESSION["last_name"]);
	unset($_SESSION["phone_number"]);
	unset($_SESSION["email"]);
	unset($_SESSION["address"]);
	unset($_SESSION["validate_errors"]);
	session_write_close();
	
	// create user
	$create_user = "INSERT INTO users VALUES ('$username','$passw', sysdate)";
	perform_sql($create_user);
	$create_person = "INSERT INTO persons VALUES ('$username','$first_name','$last_name','$address','$email','$phone_number')";
	perform_sql($create_person);
	
	// take them to login page
	header("Location: " . $url["login"] . "?username=".$username);
	exit();
	
/******
POST request from settings page
******/	
} else if (isset($_POST['change_pass'])) {

	
	$passw = $_POST['Password'];
	$repassw = $_POST['rePassword'];
	$error = check_password($passw, $repassw);
	
	if (strlen($error) > 0) {
		session_start();
		$_SESSION["validate_errors"] = $error;
		session_write_close();
	} else {
		//update
		$sql = "UPDATE USERS SET password='".$passw."' WHERE user_name='".$_COOKIE["username"]."'";
		perform_sql($sql);
	}
	
	header("Location: " . $url["settings"].'?updated=1');
	exit();
	
}else if (isset($_POST['change_first'])) {

	
	$first_name= $_POST['first_name'];
	$error = check_first($first_name);

	if (strlen($error) > 0) {
		session_start();
		$_SESSION["validate_errors"] = $error;
		session_write_close();
	} else {
		//update
		$sql = "UPDATE PERSONS SET first_name='".$first_name."' WHERE user_name='".$_COOKIE["username"]."'";
		echo $sql;
		perform_sql($sql);
	}
	
	header("Location: " . $url["settings"].'?updated=1');
	exit();
	
} else if (isset($_POST['change_last'])) {

	
	$last_name= $_POST['last_name'];
	$error = check_last($last_name);

	if (strlen($error) > 0) {
		session_start();
		$_SESSION["validate_errors"] = $error;
		session_write_close();
		
	} else {
		//update
		$sql = "UPDATE PERSONS SET last_name='".$last_name."' WHERE user_name='".$_COOKIE["username"]."'";
		perform_sql($sql);
		echo $sql;
	}
	
	header("Location: " . $url["settings"].'?updated=1');
	exit();
	
} else if (isset($_POST['change_email'])) {

	
	$email= $_POST['email'];
	$error = check_email($email);

	if (strlen($error) > 0) {
		session_start();
		$_SESSION["validate_errors"] = $error;
		session_write_close();
	} else {
		//update
		$sql = "UPDATE PERSONS SET email='".$email."' WHERE user_name='".$_COOKIE["username"]."'";
		perform_sql($sql);
	}
	
	header("Location: " . $url["settings"].'?updated=1');
	exit();
	
} else if (isset($_POST['change_phone'])) {

	
	$phone_number = $_POST['phone_number'];
	$error = check_phone($phone_number);

	if (strlen($error) > 0) {
		session_start();
		$_SESSION["validate_errors"] = $error;
		session_write_close();
	} else {
		//update
		$sql = "UPDATE PERSONS SET phone='".$phone_number."' WHERE user_name='".$_COOKIE["username"]."'";
		perform_sql($sql);
	}
	
	header("Location: " . $url["settings"].'?updated=1');
	exit();
	
} else if (isset($_POST['change_addr'])) {
	$address = $_POST['address'];
	$error = check_addr($address);

	if (strlen($error) > 0) {
		session_start();
		$_SESSION["validate_errors"] = $error;
		session_write_close();
		
	} else {
		//update
		$sql = "UPDATE PERSONS SET address='".$address."' WHERE user_name='".$_COOKIE["username"]."'";
		perform_sql($sql);
	}
	
	header("Location: " . $url["settings"].'?updated=1');
	exit();
} 

/******
Internal functions to validate registration/settings inputs
******/	
function check_username($username) {
	if (empty($username)) {
		return "Please enter your username<br>";
	} else {
		// check if username is in use
		$user_check = 'SELECT user_name FROM users WHERE user_name =\''.$username.'\'';
		$results = get_sql_results($user_check);
		if (count($results) != 0) {
			return "Username is already in use<br>";
		}
	}
	return "";
}

function check_password($passw, $repassw) {
	if (empty($passw) || empty($repassw)) {
		return "Please enter and confirm your password<br>";
	} else if ($passw != $repassw) {
		return "Passwords don't match!<br>";
	}
	return "";
}

function check_first($first_name) {
	if (empty($first_name)) {
		return  "Please enter your first name<br>";
	}
	return "";
}

function check_last($last_name) {
	if (empty($last_name)) {
		return  "Please enter your last name<br>";
	}
	return "";
}

function check_phone($phone_number) {
	if (empty($phone_number)) {
		return  "Please enter your phone number<br>";
	} else if (strlen($phone_number) > 10) {
		return "Please enter a valid phone number<br>";
	}
	return "";
}

function check_addr($address) {
	if (empty($address)) {
		return  "Please enter your address<br>";
	} 
	return "";
}

function check_email($email) {
	if (empty($email)) {
		return  "Please enter your email<br>";
	} else {
		// check if email is in use
		$email_check = 'SELECT email FROM persons WHERE email =\''.$email.'\'';
		$results = get_sql_results($email_check);
		if (count($results) != 0) {
			return  "Email is already in use<br>";
		}
	}
	return "";
}

?>

