<?php
session_start();
include("../user_management/welcome_main.php");
include("create_data_cube.php");
?>

<?php
    // Display data analysis results if any
    if (isset($_SESSION['same_analysis_session'])) {
        unset($_SESSION['same_analysis_session']);
        echo 'Refresh the page if you want to refresh the Data Cube.';
    } else {
        create_data_cube();
        echo 'Data Cube generated.';
    }
    
?>


<html>
<body>

    <form action="perform_analysis.php" method="post"
    enctype="multipart/form-data">
   
    <table  border=1>
    <tr> <td> Select Dimension</td> <td>Slice&Dice Dimension</td></tr>
    <tr>
        <td><input type="checkbox" name="User" value="User">User</td>
        <td><input type="text" name="UserSpecify" ></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="Subject" value="Subject">Subject</td>
        <td><input type="text" name="SubjectSpecify"></td>
    </tr>
    <tr>
        <td> <input type="checkbox" name="Time" value="Time" > Time</td>
        <td>
            <input type="radio" name="Time_Dimension" value="Week_Num" >Weekly
            <select name="SpecifyWeek">
            <option value="0">Leave unspecified</option>
            <?php
            for ($i = 1; $i <= 52; $i++) {
               echo '<option value="'.$i.'">'.$i.'</option>'; 
            }
            ?>   
            </select>
        
            <br>
            
            <input type="radio" name="Time_Dimension" value="Month_Num" >Monthly
            <select name="SpecifyMonth">
            <option value="0">Leave unspecified</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
            </select>
            
            <br>
            
            <input type="radio" name="Time_Dimension" value="Year_Num" >Yearly
            <select name="SpecifyYear">
            <option value="0">Leave unspecified</option>
            <?php
            for ($i = 2013; $i >= 1900; $i--) {
               echo '<option value="'.$i.'">'.$i.'</option>'; 
            }
            ?>   
            </select>
            
        </td>
    </tr>
    </table>

    <input type="submit" name="query" value="Perform Data Analysis"/>
    </form>

<?php
    // Display data analysis results if any
    if (isset($_SESSION['cube_results']) && isset($_SESSION['cube_columns']) ) {
        echo '<table border =1>';
        
        // Display the column headers
        echo '<tr>';
        foreach ($_SESSION['cube_columns'] as $column) {
            echo '<td>'.$column.'</td>';
        }
        echo '</tr>';
        
        // Display the results 
        foreach ($_SESSION['cube_results'] as $row) {
            echo '<tr>';
            foreach ($row as $item) {
                echo '<td>'.$item.'</td>';
            }
            echo '</tr>';
        }
    
        echo '</table>';
        
        // Clear the session
        unset($_SESSION['cube_results']);
        unset($_SESSION['cube_columns']);
    }
    session_write_close();
?>

</body>
</html>