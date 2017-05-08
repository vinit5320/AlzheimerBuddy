<?php

require 'dbconn.php';

$table = $_POST['table'];
$func = $_POST['func'];
if($table == "things" && $func == "update")
{
	$obname = $_POST['obname'];
	$obloc = $_POST['obloc'];
	$user_name = $_POST['uname'];

	$query = $conn->query("Update things set location = '$obloc' where name ='$obname' and uname = '$user_name'");
	echo 'success';
}
else if($table == "things" && $func == "delete")
{
	$obname = $_POST['obname'];
	$user_name = $_POST['uname'];

	$query = $conn->query("delete from things where name ='$obname' and uname = '$user_name'");
	echo 'success';
}
else if($table == "memories" && $func == "update")
{
	$name = $_POST['name'];
	$memory = $_POST['memory'];
	$user_name = $_POST['uname'];

	$query = $conn->query("Update memories set memory = '$memory' where person ='$name' and uname = '$user_name'");
	echo 'success';
}
else if($table == "memories" && $func == "delete")
{
	$name = $_POST['name'];
	$user_name = $_POST['uname'];

	$query = $conn->query("delete from memories where person ='$name' and uname = '$user_name'");
	echo 'success';
}
?>