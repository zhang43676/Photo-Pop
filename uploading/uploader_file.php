<?php
# include execute tool and side bar
include("../support/execute_sql.php");
require_once("../redirection.php");
require_once("../user_management/welcome_main.php");
?>

<?php
# function of resize_image
# create thumbnail
function resize_image($file, $w, $h , $crop = false)
{
   list($width, $height) = getimagesize($file);
   $r = $width / $height;
   if ($crop) {
      if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
      } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
      }
      $newwidth = $w;
      $newheight = $h;
   } else {
      if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
      } else {
            $newheight = $w / $r;
            $newwidth = $w;
      }
   }
   $src = imagecreatefromjpeg($file);
   $dst = imagecreatetruecolor($newwidth,$newheight );
   imagecopyresampled($dst,$src ,0 ,0 ,0 ,0 ,$newwidth ,$newheight ,$width ,$height);
   return $dst;
}

$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG");

$select_month = $_POST['DateOfMonth'];
$select_day = $_POST['DateOfDay'];
$select_year = $_POST['DateOfYear'];
$subject = $_POST['subject'];
$place = $_POST['place'];
$permission = $_POST['permission_select'];
$description = $_POST['description'];
$time = "$select_year-$select_month-$select_day";

$count = sizeof($_FILES['file']['name']);

for ($i=0; $i<$count; $i++) {

   $temp = explode(".", $_FILES["file"]["name"][$i]);
   $extension = end($temp);
#check the format of files
#accept git,jpg, pjpeg, png
#accept size of image is 2MB
   if ((($_FILES["file"]["type"][$i] == "image/gif") || ($_FILES["file"]["type"][$i] == "image/jpeg") ||
		($_FILES["file"]["type"][$i] == "image/jpg") || ($_FILES["file"]["type"][$i] == "image/JPG") ||
		($_FILES["file"]["type"][$i] == "image/pjpeg") || ($_FILES["file"]["type"][$i] == "image/x-png") ||
		($_FILES["file"]["type"][$i] == "image/png")) && ($_FILES["file"]["size"][$i] < 10000000) && in_array($extension, $allowedExts)) {

	  if ($_FILES["file"]["error"][$i] > 0) {
		 echo "<br>Bad file!";
	  }else {
		 echo "<br>Your file " . $_FILES["file"]["name"][$i] . " successfully uploaded!!<br>";
		 echo "Type: " . $_FILES["file"]["type"][$i] . "<br>";
		 echo "Size: " . ($_FILES["file"]["size"][$i] / 1024) . " kB<br>";

		 $image_file = file_get_contents($_FILES["file"]["tmp_name"][$i]);

		 $img = resize_image($_FILES["file"]["tmp_name"][$i], 150, 150);
		 ob_start();
#create thumbnail file in serivice
		 imagejpeg($img, 'thumbnail.jpg');
		 $img_file = file_get_contents ('thumbnail.jpg');
		 ob_end_clean();
		 $image_source2 = imagecreatefromstring($img_file);
		 ob_start();
		 imagepng($image_source2);
		 $contents2 = ob_get_contents();
		 ob_get_clean();

		 // Display the thumbnail
		 echo "<img src='data:image/png;base64," . base64_encode($contents2) . "' />";



		 $conn = &get_connection();
# get the max photo_id
		 $sql = "SELECT MAX(photo_id) FROM images";
		 $results = get_sql_results($sql);
		 if (count($results) == 0) {
			 $myblobid = 0;
		 } else {
			 $myblobid = array_shift(array_shift($results)) + 1;
		 }
# write images to blob
		 $lob = oci_new_descriptor($conn, OCI_D_LOB);
		 $lob2 = oci_new_descriptor($conn, OCI_D_LOB);
		 $sql = "INSERT INTO images(photo_id,photo,thumbnail) VALUES(:myblobid, :blobdata, :blobdata2)";
		 $s = oci_parse($conn, $sql);
		 oci_bind_by_name($s, ':myblobid', $myblobid);
		 oci_bind_by_name($s, ':blobdata', $lob, - 1, OCI_B_BLOB);
		 oci_bind_by_name($s, ':blobdata2', $lob2, - 1, OCI_B_BLOB);
		 $lob->writeTemporary($image_file, OCI_TEMP_BLOB);
		 $lob2->writeTemporary($img_file, OCI_TEMP_BLOB);
		 oci_execute($s,OCI_NO_AUTO_COMMIT);
		 oci_commit($conn);
		 $lob->close();
		 $lob2->close();
# write information to image
		 $sql = "UPDATE images SET owner_name = '".$_COOKIE["username"]."', permitted = '".$permission."', subject = '".$subject."', place = '".$place."', description = '".$description."', timing = DATE '".$time."' WHERE photo_id = '".$myblobid."'";
		 perform_sql($sql);

		 // Display the uploaded photo
		 $sql = "SELECT photo FROM images WHERE photo_id=".$myblobid;
		 $results = get_sql_results($sql);
		 $img_fetch = array_shift(array_shift($results));
		 echo "<img src='data:image/png;base64," . base64_encode($img_fetch->load()) . "' />";

		 oci_close($conn);

	  }
   }else {
	  echo "<br>Bad file!";
   }
}

?>

