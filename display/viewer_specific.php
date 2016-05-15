<?php 
//INCLUDES GO HERE - Welcome_main already has cookies_expire.php included
require_once("../user_management/welcome_main.php");
require_once("../security/get_group_data.php");
require_once("../support/execute_sql.php");
require_once("click_processor.php");

//Takes the photo ID to view as a parameter
$Photo_to_view = $_GET["Photo_ID"];
$username = $_COOKIE["username"];

//ACTUAL FUNCTION - Display one single image
$sql = 'SELECT Photo_ID,Owner_Name,Permitted,NVL(Subject,\' \'),NVL(Place,\' \'),NVL(Timing,DATE \'1800-10-10\'),NVL(Description,\' \'),Thumbnail,Photo FROM images WHERE Photo_ID='.$Photo_to_view;

$results = get_sql_results($sql);		//Get the result of the SQL query - A single 

$photo = array_shift($results);			//Get the individual photo from array
$i = 0;
foreach ($photo as $item) {			//Loop through the parameters of the image
	$i = $i + 1;
	if($i==1)$Photo_ID=$item;
	if($i==2)$Owner_Name=$item;
	if($i==3)$Permitted=$item;
	if($i==4)$Subject=$item;
	if($i==5)$Place=$item;
	if($i==6)$Timing=$item;
	if($i==7)$Description=$item;
	if($i==8)$Thumbnail=$item;
	if($i==9)$Photo=$item;
}

// Because we are using URL paramters, need to check the access incase user messes up the URL
$invalid_access = false;
if ($Permitted==1 || (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1)) {
	$invalid_access = false;
} else if ($Permitted==2) {
	if ($Owner_Name != $username) $invalid_access = true;
} else {
	$result = check_user_in_group($Permitted, $username);
	if (count($result) == 0) $invalid_access = true;
}
if ($invalid_access) {
	//kick user back to images
	header("Location: " . $url["view_limited"]);
	exit();
}

// Process the click count for this image
click_count($Photo_to_view, $username);

//Get group parameter
$sql = ' SELECT group_name FROM groups WHERE group_id='.$Permitted;
$results = get_sql_results($sql);
$row = array_shift($results);
$Group = array_shift($row);

//Check if the photo belongs to the owner, if is_owner = 0 then no, if is_owner = 1 yes.
$sql = 'SELECT COUNT(*) FROM images WHERE owner_name =\''.$_COOKIE['username'].'\' AND Photo_ID='.$Photo_to_view;
$results = get_sql_results($sql);
$row = array_shift($results);
$is_owner = array_shift($row);

?>

<html>
<body>

<!--Displaying the photo on the left and details menu bar on the right-->
<div id="browser">

	<div id="frame" style="width:80%;margin-left:auto; margin-right:auto">

		<div id="content" style="float:left;">
			<?php echo '<img src="data:image/jpg;base64,' . base64_encode($Photo->load()) . '" height=60% />';?>
		</div>

		<div id="menu" style="background-color:#FFD700;height:60%;width:200px;float:right;">
			<?php
			echo "<b>Posted by: </b>".$Owner_Name."<br>";
			echo "<b>to Group: </b>".$Group."<br><br>";
			echo "<b>Place: </b>".$Place."<br>";
			echo "<b>Subject: </b>".$Subject."<br>";
			echo "<b>When: </b>".$Timing."<br>";
			echo "<b>Description: </b>".$Description."<br>";
			if($is_owner == 1)//Check if the person is the owner, if they are the owner, let them edit
				echo '<form action="viewer_edit.php" method="post">
						<input type="hidden" name="photoid" value ='.$Photo_to_view.'>
						<input type="hidden" name="group" value ='.$Permitted.'>
						<input type="hidden" name="place" value ='.$Place.'>
						<input type="hidden" name="subject" value ='.$Subject.'>
						<input type="hidden" name="description" value ='.$Description.'>
						<input type="submit" name="edit_photo" value="Edit"/>
					</form>';
			?>
		</div>

	</div>

</div>

</body>
</html> 
