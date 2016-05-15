<?php
require_once("get_group_data.php");
require_once("../redirection.php");
require_once("../user_management/welcome_main.php");
?>

<html>
<body>

<?php
	$id = $_GET["group"];
	$username = $_COOKIE["username"];
	$is_owner = false;
	
	$result = check_user_in_group($id, $username);
	
	if (count($result) == 0) {
		// this was not a re-direct using our UI, user changed the url paramter to something illegal
		// they aren't allowed to see this group!!
		header("Location: " . $url["groups_main"]);
	}
	
	$result = get_group_name_and_creator($id);
	$owner_name = array_shift($result);
	$group_name = array_shift($result);
			
	if ($owner_name == $username) {
		$is_owner = true;
	}
	
	echo '<h1>'.$group_name;
	if ($is_owner) {
		//Allow owner to delete group
		echo '<form action="change_group_data.php" method="post">';
		echo '<input type="hidden" name="groupid" value='.$id.'>';
		echo '<input type="submit" name="delete_group" value="Delete Group"/>';
		echo '</form>';
	}
	echo '</h1>';


	//Allow members to change notice
	echo '<form action="change_group_data.php" method="post">';
	echo 'Notice: <input type="text" name="notice">';
	echo '<input type="hidden" name="membername" value='.$username.'>';
	echo '<input type="hidden" name="groupid" value='.$id.'>';
	echo '<input type="submit" name="change_notice" value="Change My Notice"/>';
	echo '</form>';
?>


<h1>Group Members</h1>

<FONT COLOR="FF0000">
<?php
	if (isset($_GET["error"])) {
		echo htmlspecialchars($_GET["error"]) . " is not a member or already part of the group!";
	} 
?>
</FONT>

<?php

if ($is_owner) {
	//Allow owner to add new members
	echo '<form action="change_group_data.php" method="post">';
	echo 'Member Name: <input type="text" name="membername">';
	echo '<input type="hidden" name="groupid" value='.$id.'>';
	echo '<input type="submit" name="add_member" value="Add New Member"/>';
	echo '</form>';
} ?>

<?php
	echo '<table width="100%" border=1>';
	echo '<tr>';
	echo '<td> Member Name </td>' ;
	echo '<td> Date Added </td>' ;
	echo '<td> Notice </td>' ;
	
	if ($is_owner) {
		//Allow owner to delete members
		echo '<td> Kick Out Member </td>' ;
	}
	
	echo '</tr>';

	$result = get_group_members($id);

	// Display member info for each member
	foreach ($result as $member) {
		echo '<tr>';
		$membername = "";
		foreach ($member as $item) {
			if ($membername == "") {
				//first item is member name
				$membername = $item;
			}
			echo '<td>'.$item. '</td>' ;
		}
		
		if ($is_owner && ($membername != $owner_name)) {
			//Allow owner to delete members (not themselves though)
			echo '<td>';
			echo '<form action="change_group_data.php" method="post">';
			echo '<input type="hidden" name="membername" value='.$membername.'>';
			echo '<input type="hidden" name="groupid" value='.$id.'>';
			echo '<input type="submit" name="delete_member" value="Kick Out Member"/>';
			echo '</form>';
			echo '</td>';
		}
		
		echo '</tr>';
	}

	echo '</table>';
?>

</body>
</html>