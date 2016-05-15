<?php
include("../user_management/welcome_main.php");
?>

<html>
<body>

    <div align=center>
    Select the # of files to upload: <form action="uploader_main.php" method="post">
    <select name="NumOfFiles">
    <?php
        for ($i = 1; $i <= 20; $i++) {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
    ?>
    </select>
    <input type="submit" name="upload" value="Start Uploading"/>
    </form></div>
</body>
</html>