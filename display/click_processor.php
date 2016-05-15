<?php
require_once("../support/execute_sql.php");

function click_count($Photo_to_view, $username) {

    //This will return a 0 or 1 value representing whether it is True(1) or Not(0) that the user has seen this photo before
    $sql = 'SELECT COUNT(*) FROM click_count WHERE photo_id ='.$Photo_to_view.' AND viewed_by = \''.$username.'\'';
    $results = get_sql_results($sql);
    $row = array_shift($results);
    $col = array_shift($row);
    
    /*
    If $col = 0, then the user has never clicked this photo before, mark that the user has viewed this photo
    If $col = 1, then the user has seen this photo before, nothing needs to be done, continue displaying the photo
    */
    if($col==0){
        $sql = 'INSERT INTO click_count VALUES('.$Photo_to_view.',\''.$username.'\')';
        perform_sql($sql);
        $sql = 'SELECT total_views FROM clicks_per_photo WHERE photo_id ='.$Photo_to_view;
        perform_sql($sql);
        $results = get_sql_results($sql);
        if(count($results) == 0){ 	//If there are no record of this photo's total click count, init it
            $sql = 'INSERT INTO clicks_per_photo VALUES('.$Photo_to_view.',1)';
            perform_sql($sql);
        }
        else{				//If there is a record of this photo's total click count, +1
            $row = array_shift($results);
            $col = array_shift($row);
            $col = $col + 1;
            $sql = 'UPDATE clicks_per_photo set total_views='.$col.' WHERE photo_id='.$Photo_to_view;
            perform_sql($sql);
        }
    }
}

?>
