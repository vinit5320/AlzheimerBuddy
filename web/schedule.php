<?php
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
//error_reporting(0);
?>
<html>
<head>

	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Alzheimer Buddy</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <style>
  body {
    background-color: #f8f8f8 !important;
  }
  .center{
    text-align: center;
  }

  .tr-align{
    text-align: center;
  }
  </style>

  <?php
  session_start();
  require "dbconn.php";
  require "dashboard.php";

  $user_name = $_SESSION['userSession'];
  
  $query1 = "select id from users where uname = '$user_name'";
  $result = $conn->query($query1);
  $row = mysqli_fetch_assoc($result);
  $user_id = $row['id'];
  
  if(isset($_POST['btn_add']))                                 
  {
    $eventname = $_POST['event_name'];
    $date = $_POST['date_input'];
    $time = $_POST['time_input'];

    if($eventname == "" || $date == "" || $time == "")
    {
      echo "<script type='text/javascript'>alert('Please enter all values in the field.');</script>";
    }
    else
    {
      $query2 = "insert into schedule values ('$user_id', '$eventname', '$date', '$time')";
      $result = $conn->query($query2);
    }
  }

  ?>
</head>

<body>
  <?php echo '<center><p class="lead" style="padding-top: 15px;">Schedule</p></center><hr width="80%">';?>
  <br>

  <div>
    <form method="post" class="navbar-form navbar-left" role="search" style="padding-left: 28%; padding-bottom: 4%;">
      <input type="text" class="form-control" placeholder="Event" name="event_name">
      <input type="date" class="form-control" placeholder="Date" name="date_input">
      <input type="time" class="form-control" placeholder="Time" name="time_input">
      <button type="submit" class="btn btn-primary" name="btn_add">Add</button>
    </form>
  </div>
  <br>
  <?php echo '<br><hr width = "75%"><br>
              <div class="container"> 
              <table class="table">
                <thead>
                  <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>';

                $query3 = "select * from schedule where user_id = '$user_id'";
                $result = $conn->query($query3);

                while($row_ob = mysqli_fetch_array($result))
                {
                  echo '<tr>
                    <td>'.$row_ob[1].'</td>
                    <td>'.$row_ob[2].'</td>
                    <td>'.$row_ob[3].'</td>
                  </tr>';
                }

                echo '</tbody>
              </table>
            </div>';
?>

</body>
</html>