<?php
# include execute and side bar
require_once("../support/execute_sql.php");
require_once("../user_management/welcome_main.php");

# select all the photo_id that current user can see
$sql = "SELECT photo_id FROM images WHERE owner_name = '".$_COOKIE["username"]."' or permitted = 1 or permitted in (SELECT group_id FROM groups WHERE user_name = '".$_COOKIE["username"]."' UNION SELECT g.group_id FROM group_lists gl, groups g WHERE gl.friend_id = '".$_COOKIE["username"]."' AND g.group_id=gl.group_id)";
$results = get_sql_results($sql);
#create a array for the result of photo_id
$photo_id = array();
$count = 0;
foreach($results as $photo) {
	foreach ($photo as $item) {
		$photo_id[$count] = $item;
		$count = $count + 1;
	}
}
#throw array of photo_id to session, then redirect to thumbnails view
session_start();
$_SESSION['array']=$photo_id;
$_SESSION['message']="The photo_id you can view";
$redirect = "Location: http://clive.cs.ualberta.ca/~".$_COOKIE['ccid']."/display/viewer_list.php";
header($redirect);

?>
