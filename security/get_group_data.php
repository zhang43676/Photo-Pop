<?php	
include("../support/execute_sql.php");

// Get all the groups a user has created
function get_created_groups(){

	$sql = 'SELECT group_id, group_name, date_created  FROM groups WHERE user_name = \''.$_COOKIE["username"].'\' ';
	return get_sql_results($sql);

}

// Get all the groups a user is a part of
function get_member_groups(){

	//sql command
	//$sql = 'SELECT group_id,date_added FROM group_lists WHERE friend_id = \''.$_COOKIE["username"].'\' ';
	$sql = 'SELECT gl.group_id,date_added FROM group_lists gl, groups g WHERE gl.friend_id = \''.$_COOKIE["username"].'\' ';
	$sql .= ' and gl.group_id = g.group_id and g.user_name != \''.$_COOKIE["username"].'\' ';
		return get_sql_results($sql);
} 

function get_new_group_id(){
	$sql = 'SELECT MAX(group_id) FROM groups';
	$results = get_sql_results($sql);
	$count = array_shift(array_shift($results)) + 1;
	return $count;
}

// Get all the members of a group
function get_group_members($id){
	//sql command
	$sql = 'SELECT friend_id, date_added, NVL(notice, \' \') FROM group_lists WHERE group_id = \''.$id.'\' ';

	return get_sql_results($sql);
}

// Get group name given id
function get_group_name($id){
	//sql command
	$sql = 'SELECT group_name FROM groups WHERE group_id = \''.$id.'\' ';
	$result = get_sql_results($sql);
	
	return array_shift(array_shift($result));
}

// Get group name and user name fromgiven id
function get_group_name_and_creator($id){
	//sql command
	$sql = 'SELECT user_name, group_name FROM groups WHERE group_id = \''. $id.'\' ';
	return array_shift(get_sql_results($sql));
}

// Check if can add a new member to a group
function check_valid_new_member($id, $membername) {
	$sql = 'SELECT * FROM users WHERE user_name = \''. $membername.'\' ';
	$result = get_sql_results($sql);
	
	if (count($result) == 0) {
		return False;
	} 
	//Check they are not a member already
	$result = check_user_in_group($id, $membername);

	if (count($result) != 0) {
		return False;
	}
	
	return True;
}

// Check if user is part of a group
function check_user_in_group($id, $membername) {
	$sql = 'SELECT * FROM group_lists WHERE friend_id = \''. $membername.'\' and group_id = \''. $id.'\' ';
	return get_sql_results($sql);
}

// Get the group id and group name of all groups a user is part of
function get_group_permissions($username){
	$sql = 'SELECT group_id, group_name FROM groups WHERE user_name = \''.$username.'\' ';
	$sql .=' UNION ';
	$sql .='SELECT g.group_id, g.group_name FROM group_lists gl, groups g  WHERE gl.friend_id = \''.$username.'\' AND g.group_id=gl.group_id';

	return get_sql_results($sql);	
}


?>
