<?php
session_start();
require_once("../support/execute_sql.php");
require_once("../redirection.php");

    $user_select = $_POST["User"];
    $subject_select = $_POST["Subject"];
    $time_select = $_POST["Time"]; 
        
    $checkbox_array = array();
    array_push($checkbox_array, $user_select);
    array_push($checkbox_array, $subject_select);
    array_push($checkbox_array, $time_select);

    // Make sure user specified atleast one dimension
    $selected = array();
    for ($i = 0; $i < count($checkbox_array); $i++) {
        if (strlen($checkbox_array[$i]) > 0) {
           array_push($selected, $checkbox_array[$i]);
        }
    }
    if (count($selected) == 0) {
        header("Location: " . $url["analysis_main"]);
        exit();
    } 
    
    // Get any slices
    $user_slice = $_POST["UserSpecify"];
    $subject_slice= $_POST["SubjectSpecify"];
    $time_slice = $_POST["Time_Dimension"];
    
    $slice_array = array();
    array_push($slice_array, $user_slice);
    array_push($slice_array, $subject_slice);
    array_push($slice_array, $time_slice);
    
    // Additional time slicing
    $time_dimension_slice = "";
    $sql_ORDER = "";
        
    $user_select_sql = "V.Owner_Name";
    $subject_select_sql = "V.Subject";
    $time_select_sql = "V.Timing";
    if (strlen($time_slice ) > 0) {
        $time_slice_type = array();
        array_push($time_slice_type, "Week_Num");
        array_push($time_slice_type, "Month_Num");
        array_push($time_slice_type, "Year_Num");
        $time_slice_array = array();
        array_push($time_slice_array, $_POST["SpecifyWeek"]);
        array_push($time_slice_array, $_POST["SpecifyMonth"]);
        array_push($time_slice_array, $_POST["SpecifyYear"]);
       
        $time_select_sql = "T." . $time_slice ;
        $sql_ORDER = " ORDER BY " . $time_select_sql;
        
        for ($i=0; $i < count($time_slice_type); $i++) {
            if ($time_slice_type[$i] == $time_slice) {
                $arg = $time_slice_array[$i];
                
                if ($arg != 0 && count($arg) > 0 ) {
                    $time_dimension_slice = $time_slice_array[$i];
                    break;
                }
            }
        }
    }

    $column_array = array();
    array_push($column_array, $user_select_sql);
    array_push($column_array, $subject_select_sql);
    array_push($column_array, $time_select_sql);
    
    // Generate the SQL query
    $sql_SELECT = "SELECT ";
    $sql_GROUP = " GROUP BY ";
    for ($i = 0; $i < count($checkbox_array); $i++) {
        if (strlen($checkbox_array[$i]) == 0) {
            // Dimension was not chosen
            $column_array[$i] = $column_array[$i] . " is null";
            continue;
        }
        
        //Dimension was chosen
        if ($sql_SELECT != "SELECT ") {
            $sql_SELECT .= " ,";
            $sql_GROUP .= " ,";
        }
        $sql_SELECT .= $column_array[$i];
        $sql_GROUP .= $column_array[$i];
        
        if (strlen($slice_array[$i]) > 0) {
            // Slice was chosen
            if ($i == 2) {
                //We've already sliced, see if further slice needed
                if (strlen($time_dimension_slice) != 0) {
                    $column_array[$i] .= "='" . $time_dimension_slice. "'";
                } else {
                    $column_array[$i] .= " is not null";
                }
            } else {
                $column_array[$i] .= "='" . $slice_array[$i]. "'";
            }
           
        } else {
            $column_array[$i] .= " is not null";
        }
    }
    
    $sql_SELECT .= ", SUM(V.ImageCount)";
    $sql_FROM = " FROM imageCube V";
    $sql_WHERE = " WHERE " . $column_array[0] . " and " . $column_array[1] . " and " . $column_array[2];

    if (strlen($time_slice) > 0) {
        $sql_FROM .= ", time_dimension T";
        $sql_WHERE .= " and V.Timing = T.Time_ID";
    }
    
    $sql = $sql_SELECT . $sql_FROM . $sql_WHERE . $sql_GROUP . $sql_ORDER;
    //echo $sql;

    $results = get_sql_results($sql);

    // Return the query results
    $_SESSION['cube_results'] = $results;
    array_push($selected, "Image Count");
    $_SESSION['cube_columns'] = $selected;
    
    // Make sure to not re-generate the data cube
    $_SESSION['same_analysis_session'] = 1;
    session_write_close();
    header("Location: " . $url["analysis_main"]);
?>
