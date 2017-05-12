<?php		
	 require "dbconn.php";				

	$user_name = $_POST['uname'];

	$sqlquery = "select date(logdate) as date,count(*) as count from recentlogs 
				 where uname = '$user_name' and date(now())-date(logdate)<7
				 group by date(logdate) order by logdate desc";
    $result=$conn->query($sqlquery);
    $result_date = Array();
    $result_count = Array();
    while($row = mysqli_fetch_array($result)) {
        $result_date[] = $row[0];
        $result_count[] = $row[1];
    }
    $json_date = json_encode($result_date);
    $json_count = json_encode($result_count);

    return $json_date;

  ?>