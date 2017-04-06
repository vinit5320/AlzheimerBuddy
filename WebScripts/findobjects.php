<?php
## This is the file for making a connection to the database
## All the parameters necessary for making a connection are specified in this file.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alz_buddy";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
// If any error in the connection file then Error is displayed
$name = 'pen';



$sqlquery = "select * from objects where oname = '$name'";
$result = $conn->query($sqlquery);

$row = mysqli_fetch_assoc($result);
// echo ' <h4><strong>Objectname: '.$row[0].'</strong></h4>
// 		<h5>Location: '.$row[1].'</h5>';
print_r(json_encode($row));



?>                