<?php 
//HANDLE SESSIONS
session_start();
if(isset($_SESSION['array'])){			//If session is set
	$display_list = $_SESSION['array'];	//Load array in session into display_list
}
else	echo "ERROR - NO ARRAY <br>";		//Else, Show error if there are no arrays passed in

if(isset($_SESSION['message'])){		//If session is set
	$display_message = $_SESSION['message'];//Load string in session into display_message
}
else	echo "ERROR - NO MESSAGE <br>";		//Else, Show error if there are no messages passed in

//INCLUDES GO HERE
//Welcome_main already has cookies_expire.php included
include ("../user_management/welcome_main.php"); 
include("../support/execute_sql.php");

//print($display_message);			//Display message for user !!!BROKEN FOR NOW, DO NOT USE

//Display the list of images requested in array by looping through and displaying them one by one
foreach($display_list as $display_picture){
$sql = 'SELECT Photo_ID, Thumbnail FROM images WHERE photo_id='.$display_picture;
$results = get_sql_results($sql);		//Get the result of the SQL query - A single image
$photo = array_shift($results);			//Get the individual photo from array
$i=0;
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



