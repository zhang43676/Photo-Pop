<?php
require_once("../user_management/welcome_main.php");

?>
<html>
    <body>
        <form name="search" method="post" action="search.php">
            Keyword : <input type="text" name="keyword"/>
            <input type="submit" name="validate" value="Search"/><br/>
              From : <select name="FromDateOfMonth">
   <option>- Month -</option>
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
   <select name="FromDateOfDay">
   <option>- Day -</option>
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
   <select name="FromDateOfYear">
   <option>- Year -</option>
       <?php
     for ($i = 2013; $i >= 1900; $i--) {
        echo '<option value="'.$i.'">'.$i.'</option>'; 
     }
    ?>  
     </select><br/>
                   To : <select name="ToDateOfMonth">
   <option>- Month -</option>
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
   <select name="ToDateOfDay">
   <option>- Day -</option>
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
   <select name="ToDateOfYear">
   <option>- Year -</option>
      <?php
     for ($i = 2013; $i >= 1900; $i--) {
        echo '<option value="'.$i.'">'.$i.'</option>'; 
     }
    ?>  
     </select><br/>
   <select name ="rank_select">
   <option value = "most-recent-first">most-recent-first</option>
   <option value = " most-recent-last"> most-recent-last</option>
</select>
            <input type="submit" name="validate_time" value="Search"/><br/>
        </form>
    </body>
</html>
