<?php
require_once("../support/execute_sql.php");

function create_data_cube() {
    
    //First create a table to represent the dimensions of Time
    $sql =  "DROP TABLE time_dimension";
    perform_sql($sql);
    
    $sql = "CREATE TABLE time_dimension(
    time_id date,
    year_num    int,
    month_num   int,
    week_num    int,
    PRIMARY KEY(time_id)
    )";
    perform_sql($sql);
    
    //Insert values into time_dimension depending on the times
    //currently in the images
    $sql = "INSERT INTO time_dimension
    SELECT distinct trunc( timing ),
    extract(year from timing),
    extract(month from timing),
    to_char(timing, 'WW') 
    FROM images";
    perform_sql($sql);
    
    //Then the data cube is created for the image count
    //using paramters owner_name, subject, and timing
    $sql = "DROP VIEW ImageCube";
    perform_sql($sql);
    
    $sql = "CREATE VIEW ImageCube AS
    Select Owner_Name, Subject, Timing, COUNT(photo_id) AS ImageCount
    FROM images
    GROUP BY CUBE(Owner_Name, Subject, Timing)";
    perform_sql($sql);
}

?>