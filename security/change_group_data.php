<?php
require_once("get_group_data.php");
require_once("../redirection.php");

if (isset ($_POST['create'])){
	//get the input
	$groupname= $_POST['groupname'];
	$username=  $_COOKIE["username"];
	
	//sql command
	$sql = 'SELECT * FROM groups WHERE user_name = \''.$username.'\' and group_name = \''.$groupname.'\' ';
	$results = get_sql_results($sql);
	
	$redirect = "Location: " . $url["groups_main"] . "?";
	
	if (count($results) != 0) {
		$redirect = $redirect . "error=".$groupname;
		header($redirect);
		exit();
	} else {
		$count = get_new_group_id();
		
		// Create the group
		$sql = 'INSERT INTO groups VALUES ('.$count.', \''.$username.'\',\''.$groupname.'\', sysdate) ';
		echo $sql;
		perform_sql($sql);

		// Insert creator as member
		$sql = 'INSERT INTO group_lists VALUES ('.$count.', \''.$username.'\', sysdate, \'\') ';
		perform_sql($sql);

		$redirect = $redirect . "created=".$groupname;
		header($redirect);
		exit();
	}
	
} else if  (isset ($_POST['add_member'])) {
	//get the input
	$membername=$_POST['membername'];
	$groupid=$_POST['groupid'];
	
	$valid = check_valid_new_member($groupid, $membername);
	
	if ($valid) {
	// Insert member
		$sql = 'INSERT INTO group_lists VALUES ('.$groupid.', \''.$membername.'\', sysdate, \'\') ';
		perform_sql($sql);
		
		$redirect = "Location: " . $url["view_group"] . "?group=".$groupid;
		header($redirect);
		exit();
	} else {
		$redirect = "Location: " . $url["view_group"] . "?group=".$groupid."&error=".$membername;
		header($redirect);
		exit();
	}
	
} else if (isset ($_POST['delete_member'])) {
	//get the input
	$membername=$_POST['membername'];
	$groupid=$_POST['groupid'];
	
	//Update all images by this user under this group's permission to be private
	$sql = "UPDATE images SET permitted=2 WHERE owner_name ='".$membername."' and permitted ='". $groupid."'";
	perform_sql($sql);
	
	//Delete the member
	$sql = "DELETE FROM group_lists WHERE friend_id ='".$membername."' and group_id ='". $groupid."'";
	perform_sql($sql);
	
	header("Location: " . $url["view_group"] . "?group=".$groupid);
	exit();
	
} else if (isset ($_POST['delete_group'])) {
	$groupid=$_POST['groupid'];
	
	//Delete all members
	$sql = "DELETE FROM group_lists WHERE group_id ='". $groupid."'";
	perform_sql($sql);

	//Update all images under this group's permission to be private
	$sql = "UPDATE images SET permitted=2 WHERE permitted ='". $groupid."'";
	perform_sql($sql);
	
	//Delete the group
	$sql = "DELETE FROM groups WHERE group_id ='". $groupid."'";
	perform_sql($sql);
	
	header("Location: " . $url["groups_main"]);
	exit();
	
} else if(isset ($_POST['change_notice'])) {
	$notice=$_POST['notice'];
	$membername=$_POST['membername'];
	$groupid=$_POST['groupid'];
	
	$sql = "UPDATE group_lists SET notice='". $notice."' WHERE friend_id ='".$membername."' and group_id ='". $groupid."'";
	perform_sql($sql);
	
	header("Location: " . $url["view_group"] . "?group=".$groupid);
	exit();
}
?>

