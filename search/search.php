<?php
# include execute and side bar
require_once("../support/execute_sql.php");
require_once("../user_management/welcome_main.php");
# check if the current user is admin
# select all the photo_id that current user can see
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1) {
	$sql_all = "SELECT photo_id FROM images WHERE owner_name = '".$_COOKIE["username"]."' or permitted = 1 or permitted in (SELECT group_id FROM groups WHERE user_name = '".$_COOKIE["username"]."' UNION SELECT g.group_id FROM group_lists gl, groups g WHERE gl.friend_id = '".$_COOKIE["username"]."' AND g.group_id=gl.group_id)";
} else {
	$sql_all = "SELECT photo_id FROM images";
}
$results_permitted = get_sql_results($sql_all);
$photo_permitted = array();
$count = 0;
foreach($results_permitted as $photo) {
	foreach ($photo as $item) {
		$photo_permitted[$count] = $item;
		$count = $count + 1;

	}
}
# if user search by keyword
if (isset($_POST['validate'])) {
	$keyword = $_POST['keyword'];
#if user didnt input keyword
	if (empty($keyword)) {
		die("Please enter your keyword");
	}
#select photo_id that contain keyword in place,or description, or subject
	$sql = "SELECT photo_id FROM images WHERE CONTAINS(subject, '$keyword',1) >0 or CONTAINS(place, '$keyword',2)>0 or CONTAINS(description, '$keyword',3)>0 ORDER BY 6*score(1) + 3*score(2) + score(3) desc";
#create a array for the result of photo_id
	$results = get_sql_results($sql);
	$photo_id = array();
	$count = 0;
	foreach($results as $photo) {
			 foreach ($photo as $item) {
				 if (in_array($item,$photo_permitted)) {
					 $photo_id[$count] = $item;
					 echo $photo_id[$count]. "<br>";
					 $count = $count + 1;

				 }


		   }
	 }
#throw array of photo_id to session, then redirect to thumbnails view
			session_start();
	$_SESSION['array']=$photo_id;
	$_SESSION['message']="Displaying Search Results";
	$redirect = "Location: http://clive.cs.ualberta.ca/~".$_COOKIE['ccid']."/display/viewer_list.php";
	header($redirect);
}
#if user search by time range, or/and keyword
if (isset($_POST['validate_time'])) {
	$from_month = $_POST['FromDateOfMonth'];
	$from_day = $_POST['FromDateOfDay'];
	$from_year = $_POST['FromDateOfYear'];
	$to_month = $_POST['ToDateOfMonth'];
	$to_day = $_POST['ToDateOfDay'];
	$to_year = $_POST['ToDateOfYear'];
	$keyword = $_POST['keyword'];
	$from_time = "$from_year-$from_month-$from_day";
	$to_time = "$to_year-$to_month-$to_day";
#check did user input time format correct
	if (strtotime($from_time) > strtotime($to_time)) {
		die("Please type in correct time!");

	}  else{
#if keyword is blank, do a simple time range search
		if ($keyword == "") {
			if ($_POST['rank_select'] == "most-recent-first") {
				$sql = "SELECT photo_id FROM images WHERE TIMING BETWEEN DATE '$from_time' AND DATE '$to_time' ORDER BY timing DESC";

			}
			else {
				$sql = "SELECT photo_id FROM images WHERE TIMING BETWEEN DATE '$from_time' AND DATE '$to_time' ORDER BY timing ASC";

			}
# if user input something, then search keyword plus time range
		} else {
			if ($_POST['rank_select'] == "most-recent-first") {
                            $sql = "SELECT photo_id FROM images WHERE photo_id in (SELECT photo_id FROM images WHERE TIMING BETWEEN DATE '$from_time' AND DATE '$to_time' INTERSECT SELECT photo_id FROM images WHERE CONTAINS(subject, '$keyword',1) >0 or CONTAINS(place, '$keyword',2)>0 or CONTAINS(description, '$keyword',3)>0) ORDER BY timing DESC";
				//$sql = "SELECT * FROM (SELECT photo_id FROM images WHERE TIMING BETWEEN DATE '$from_time' AND DATE '$to_time' ORDER BY timing DESC) INTERSECT SELECT * FROM (SELECT photo_id FROM images WHERE CONTAINS(subject, '$keyword',1) >0 or CONTAINS(place, '$keyword',2)>0 or CONTAINS(description, '$keyword',3)>0 ORDER BY timing DESC) ORDER BY timing DESC";
				//$sql = "SELECT photo_id FROM images WHERE TIMING BETWEEN DATE '$from_time' AND DATE '$to_time' ORDER BY timing DESC";

			}
			else {
                            $sql = "SELECT photo_id FROM images WHERE photo_id in (SELECT photo_id FROM images WHERE TIMING BETWEEN DATE '$from_time' AND DATE '$to_time' INTERSECT SELECT photo_id FROM images WHERE CONTAINS(subject, '$keyword',1) >0 or CONTAINS(place, '$keyword',2)>0 or CONTAINS(description, '$keyword',3)>0) ORDER BY timing ASC";
				//$sql = "SELECT * FROM (SELECT photo_id FROM images WHERE TIMING BETWEEN DATE '$from_time' AND DATE '$to_time' ORDER BY timing ASC) INTERSECT SELECT * FROM (SELECT photo_id FROM images WHERE CONTAINS(subject, '$keyword',1) >0 or CONTAINS(place, '$keyword',2)>0 or CONTAINS(description, '$keyword',3)>0 ORDER BY timing ASC) ORDER BY timing ASC";
				//$sql = "SELECT photo_id FROM images WHERE TIMING BETWEEN DATE '$from_time' AND DATE '$to_time' ORDER BY timing ASC";

			}

		}
#create a array for the result of photo_id
		$results = get_sql_results($sql);
		$photo_id = array();
        $count = 0;
        foreach($results as $photo) {
       			foreach ($photo as $item) {
       				if (in_array($item,$photo_permitted )) {
       					$photo_id[$count] = $item;
       					echo $photo_id[$count]. "<br>";
       					$count = $count + 1;
       				}

              }
       	}
#throw array of photo_id to session, then redirect to thumbnails view
       	session_start();
        $_SESSION['array']=$photo_id;
        $_SESSION['message']="Displaying Search Results";
        $redirect = "Location: http://clive.cs.ualberta.ca/~".$_COOKIE['ccid']."/display/viewer_list.php";
        header($redirect);

    }
}

?>