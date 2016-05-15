<?php
include("../security/cookie_expire.php");
require_once("../redirection.php");
?>

<html>

<link rel = "stylesheet" type = "text/CSS" href="../photopop.css" />

<HEAD>
<TITLE>PhotoPop</TITLE>

<BODY>

<?php
//Data Required for website
$CCID="PHP IS NOT WORKING";	//Passed in username goes here
$IS_ADMIN=0;			//0 = User, 1 = Admin
    	
$CCID=$_COOKIE["username"];
session_start();
$_SESSION["admin"] = 0;
if ($CCID == "admin") {
	$IS_ADMIN=1;

	$_SESSION["admin"] = 1;
}
      		
?>

<!--This is the first line-->
<table class = "header" width="100%">
<tr>
	<?php
	echo "<td class = \"header\" align=\"left\">logged in as: $CCID</td>" ;
	echo '<td class = "header" align="right">' ;
	echo '	<a href="'.$url["help"].'">help me</a>	| '  ;
	echo '	<a href="'.$url["settings"].'">settings</a>	| '  ;
	echo '	<a href="'.$url["login"].'">logout</a> 	';
	echo '</td> '; ?> 

</tr>
</table>

<!--This is the second line-->
<table class = "menu" width="100%" border=1>
<tr>
	<td align="left" class = "menu"><?php 
	if($IS_ADMIN==1)
		echo '<a class = "menu" href="'.$url["view_all"].'">Admin View</a>'; 
	else
		echo '<a class = "menu" href="'.$url["view_limited"].'">User View</a>';
	?>
	</td>
	<td class = "menu"> <?php echo '<a class = "menu" href="'.$url["top_5"].'">Top 5</a>'; ?> </td>
	<td class = "menu"> <?php echo '<a class = "menu" href="'.$url["groups_main"].'">Groups</a>'; ?> </td>
	<td class = "menu"> <?php echo '<a class = "menu" href="'.$url["uploader_select"].'">Upload</a>'; ?></td>
	<?php
	if($IS_ADMIN==1){ //If they are administrator, enable button
		echo '<td class = "menu"><a class = "menu" href="'.$url["analysis_main"].'">Data Analysis</a></td>';
		}
	?>
	<td align="left" class = "menu"><?php echo '<a class = "menu" href="'.$url["search_main"].'">Search</a>'; ?></td>
</tr>
</table>

</html>
