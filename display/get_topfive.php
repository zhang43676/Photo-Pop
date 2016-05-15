<?php
//INCLUDES GO HERE
//Welcome_main already has cookies_expire.php included
include ("../user_management/welcome_main.php"); 
include("../support/execute_sql.php");

session_start();

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1) {
	//make sure temp view is dropped
	$sql = "DROP VIEW temp";
	perform_sql($sql);
	
	//create a view of viewable photo id's
	$sql = "CREATE VIEW temp AS SELECT photo_id FROM images WHERE owner_name = '".$_COOKIE["username"];
	$sql .= "' or permitted = 1 or permitted in (SELECT group_id FROM groups WHERE user_name = '".$_COOKIE["username"];
	$sql .="' UNION SELECT g.group_id FROM group_lists gl, groups g WHERE gl.friend_id = '".$_COOKIE["username"]."' AND g.group_id=gl.group_id)";
	perform_sql($sql);
	
	$sql = 'SELECT cpp.photo_id, total_views FROM clicks_per_photo cpp, temp t WHERE cpp.photo_id = t.photo_id ORDER BY total_views DESC';
} else {
	$sql = 'SELECT * FROM clicks_per_photo ORDER BY total_views DESC';
}

$results = get_sql_results($sql);

//Initialize variables
$row_itr = 0;
$col_itr = 0;
$fifth_place = -1;
$photo_id = array();
$photo_itr = 0;
$photo_temp = -1;

//Find top 5 loop and store it in $
foreach($results as $row){
	$row_itr = $row_itr + 1;

	foreach($row as $col){
		$col_itr = $col_itr + 1;
		if($col_itr == 1 && $row_itr <= 5){	//get top 5 photo_id, Put them into an array
			$photo_id[$photo_itr] = $col;
			$photo_itr = $photo_itr + 1;
		}
		if($col_itr == 2 && $row_itr == 5){	//mark the click count of the fifth place
			$fifth_place = $col;
		}
		if($col_itr == 1 && $row_itr > 5){
			$photo_temp = $col;
		}
		if($col_itr == 2 && $col == $fifth_place && $photo_temp != -1){	//record all other photos that have same click count as fifth photo
			$photo_id[$photo_itr] = $photo_temp;
			$photo_itr = $photo_itr + 1;
		}

	}
	$col_itr = 0;
}
//List of photo_id is prepared, save them in as SESSION variables for passing
session_start();
$_SESSION['array']=$photo_id;
$_SESSION['message']="Displaying Top 5";
//Finished storing SESSION variables, redirect to viewer
$redirect = "Location: http://clive.cs.ualberta.ca/~".$_COOKIE['ccid']."/display/viewer_list.php";
header($redirect);
?>
