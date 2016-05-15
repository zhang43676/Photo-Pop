<?php 
//INCLUDES GO HERE - Welcome_main already has cookies_expire.php included
require_once("../user_management/welcome_main.php"); 
require_once("../security/get_group_data.php");
require_once("../redirection.php");

if (isset($_POST["edit_photo"])) {
    //Get the original information to auto-fill in the fields for the user
    $photoid = $_POST["photoid"];
    $permitted = $_POST["group"];
    $place = $_POST["place"];
    $subject = $_POST["subject"];
    $description = $_POST["description "];
    
} else if (isset($_POST["update_photo"]))  {
    //This is called after pressing "Update"
    //Get the users values (may contain a mix of modfied or new information but just update everything in case)
    $photoid = $_POST["photoid"];
    $place = $_POST["place"];
    $subject = $_POST["subject"];
    $description = $_POST["description"];
    $permitted = $_POST["permission_select"];
    
    //Update the image
    $sql = "UPDATE images SET place='".$place."', subject ='".$subject."',description='".$description;
    $sql .= "', permitted='".$permitted."' WHERE photo_id =".$photoid;
    perform_sql($sql);
    
    //Return the user to view the image
    header("Location: " . $url["viewer_specific"]."?Photo_ID=".$photoid);
    exit();
}?>

    <form action="viewer_edit.php" method="post"
    enctype="multipart/form-data">
    
    Subject : <input type = "text" name = "subject" value="<?php echo $subject; ?>" /><br/>
    Place : <input type="text" name = "place" value="<?php echo $place; ?>" /><br/>
    Permission: <select name ="permission_select">
    
    <?php 
        if ($group == 1) {
            echo '<option value = "1" selected="true">Public</option>';
            echo '<option value = "2" >Private</option>';
        } else if ($group == 2) {
            echo '<option value = "1">Public</option>';
            echo '<option value = "2" selected="true">Private</option>';
        } else {
            echo '<option value = "1">Public</option>';
            echo '<option value = "2">Private</option>';
        }

        $result = get_group_permissions($_COOKIE["username"]);

        foreach ($result as $group) {
            $id = array_shift($group);
            $group_label = $id . ": " .array_shift($group);
            $option = '<option value = "'.$id;
            if ($id == $permitted) {
                $option .= '" selected="true">';
            } else {
                $option .= '">';
            }
            $option .= $group_label.'</option>';
            
            echo $option;
        }
        
    ?>
    </select><br/>
       
    Description: <textarea name="description" cols="30" rows="3"
    <?php echo 'value=\''.$description.'\''; ?>></textarea><br/>
    
    <input type="hidden" name="photoid" value="<?php echo $photoid; ?>">
    <input type="submit" name="update photo" value="Update">
    </form>



