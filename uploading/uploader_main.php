<?php
include("../user_management/welcome_main.php");
include("../security/get_group_data.php");
?>

<html>
<body>

    <FONT COLOR="FF0000">
        <?php
        if (isset($_GET["error"])) {
            echo "Invalid file!";
        } 
    ?>
    </FONT>

    
    <form action="uploader_file.php" method="post"
    enctype="multipart/form-data">
    
    Subject : <input type = "text" name = "subject"/><br/>
    Place : <input type="text" name = "place"/><br/>
    
    When : <select name="DateOfMonth">
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
    </select>
    
    <select name="DateOfDay">
    <?php
        for ($i = 1; $i <= 31; $i++) {
            if ($i < 10) {
                echo '<option value="0'.$i.'">'.$i.'</option>';
            } else {
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
        }
    ?>
    </select>
    
    <select name="DateOfYear">
    <?php
     for ($i = 2013; $i >= 1900; $i--) {
        echo '<option value="'.$i.'">'.$i.'</option>'; 
     }
    ?>   
    </select><br/>
    
    Permission: <select name ="permission_select">
    <option value = "1">Public</option>
    <option value = "2" selected="true">Private</option>
    <?php
        $result = get_group_permissions($_COOKIE["username"]);

        foreach ($result as $group) {
            $id = array_shift($group);
            $group_label = $id . ": " .array_shift($group);
            echo '<option value = "'.$id.'">'.$group_label.'</option>';
        }
        
    ?>
    </select><br/>
       
    Description: <textarea name="description" cols="30" rows="3"></textarea><br/>
    
    
    <br><label for="file">Filename:</label><br>
    
    <?php
    $count = 1;
    if (isset($_POST["NumOfFiles"]) && $_POST["NumOfFiles"]) {
        $count = $_POST["NumOfFiles"];
    }
    for ($i = 0; $i < $count; $i++ ) {
        echo '<input type="file" name="file[]" id="file"><br>';
    }
    ?>
    <br>
    <input type="submit" name="submit" value="Submit">
    <input type="reset" name="reset_all" value="Reset"/>
    </form>

</body>
</html>
