<?php 
require_once("PHPconnectionDB.php");

//Get a connection
function &get_connection() {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	//establish connection
	$conn=connect();
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	} else {
		return $conn;
	}
    
}

//Execute an SQL statement 
function perform_sql($sql) {
	$stmnt = &execute_sql($sql);
	oci_free_statement($stmnt);
}

//Execute an SQL statement and return the resulting array
function get_sql_results($sql) {
	$stmnt = &execute_sql($sql);
	$result = array();
	while ($row = oci_fetch_array($stmnt, OCI_ASSOC)) {
		array_push($result, $row);
    }
	// Free the statement identifier when closing the connection
	oci_free_statement($stmnt);
	
	return $result;
}

//Connects and executes the SQL statement (internal function)
function &execute_sql($sql) {
	$conn = &get_connection();

	//Prepare sql using conn and returns the statement identifier
	$statement = oci_parse($conn, $sql);

	//Execute a statement returned from oci_parse()
	$res=oci_execute($statement);

	//Release the connection
	oci_close($conn);
	
	if ($res) {
		//Return the query results
		return $statement;
	} else {
		$err = oci_error($statement); 
		echo htmlentities($err['message']);
	}
}

?>