<?php
require_once("../user_management/welcome_main.php");
require_once("get_group_data.php");
require_once("../redirection.php");
?>

<html>
<body>

<h1>Groups I've Created</h1>

<FONT COLOR="FF0000">
<?php
	if ($_GET["error"]) {
		echo "You've already created the group '" . htmlspecialchars($_GET["error"]) . "'!";
	} 
?>
</FONT>
<FONT COLOR="008000">
<?php
	if ($_GET["created"]) {
		echo "Group '" . $_GET["created"]."' created!";
	}
?>
</FONT>

<form action="change_group_data.php" method="post">
Group Name: <input type="text" name="groupname">
<input type="submit" name="create" value="Create New Group"/>
</form>
		
<?php
	$result = get_created_groups($_COOKIE["username"]);

	echo '<table width="100%" border=1>';
	echo '<tr>';
	echo '<td> Group ID </td>' ;
	echo '<td> Group Name </td>' ;
	echo '<td> Date Created </td>' ;
	echo '<td> Edit Group </td>';
	echo '</tr>';
	
	foreach ($result as $group) {
		echo '<tr>';
		
		$id = "";
		foreach ($group as $item) {
			//first item is the group id
			if ($id == "") {
				$id = $item;
			}
			echo '<td>'.$item. '</td>' ;
		}
		
		echo '<td>';
		$path = $url["view_group"] . "?group=".$id;
		echo '<a href="'.$path.'">Edit</a>';
		echo '</td>';
		
		echo '</tr>';
	}

	echo '</table>';
?>

<h1>Groups I'm In</h1>

<?php
$result = get_member_groups($_COOKIE["username"]);

	echo '<table width="100%" border=1>';
	echo '<tr>';
	echo '<td> Group ID </td>' ;
	echo '<td> Group Name </td>' ;
	echo '<td> Date Added </td>' ;
	echo '<td> View Group </td>' ;
	echo '</tr>';

	//Display extracted rows
	foreach ($result as $group) {
		echo '<tr>';

		$id = "";
		foreach ($group as $item) {
			echo '<td>'.$item. '</td>' ;
			
			//first item is the group id
			if ($id == "") {
				$id = $item;
				
				// Get group name				
				$name = get_group_name($id);
				echo '<td>'.$name.'</td>' ;
			} 
		}
		
		echo '<td>';
		$path = $url["view_group"] . "?group=".$id;
		echo '<a href="'.$path.'">View</a>';
		echo '</td>';
		
		echo '</tr>';
   }
	
	echo '</table>';

?>

</body>
</html> 
