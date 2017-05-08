
<?php
## This is the file for making a connection to the database
## All the parameters necessary for making a connection are specified in this file.
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "alz_buddy";
// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
// If any error in the connection file then Error is displayed


$conn = mysqli_connect('mysqlforlambdatest.cxjr41nyvqjk.us-east-1.rds.amazonaws.com', 'keval','mypassword', 'alz_db', '3306');

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
	// echo "Connection made";
}
?>
    