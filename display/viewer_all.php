<?php 
//INCLUDES GO HERE
//Welcome_main already has cookies_expire.php included
include ("../user_management/welcome_main.php"); 
include("../support/execute_sql.php");

$sql = 'SELECT Photo_ID, Thumbnail FROM images';	//SQL Query - Get all photos in the database

$results = get_sql_results($sql);			//Get the result of the SQL query - All images in database

foreach ($results as $photo) {				//Loop through all images
	$i = 0;
	foreach ($photo as $item) {			//Loop through the parameters of the image
		$i = $i + 1;
		if($i==1)$Photo_ID=$item;
		if($i==2)$Thumbnail=$item;
	}
	//Displaying the photo
	echo '<div id="pictures" style="float:left;padding-left:6px;padding-right:6px;">';			//Photo style
	echo '<a href="viewer_specific.php?Photo_ID='.$Photo_ID.'">';						//Photo's hyperlink
	echo '<img border="0" src="data:image/jpg;base64,' . base64_encode($Thumbnail->load()) . '"></a></p>';	//Photo itself
	echo '</div>';
}
?>
