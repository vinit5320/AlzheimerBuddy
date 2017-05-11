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
  </style>

  <?php
  session_start();
  require "dbconn.php";
  require "dashboard.php";
 

  $user_name = $_SESSION['userSession'];

  echo '<center><p class="lead" style="padding-top: 15px;">Hello '.$user_name.'</p></center><hr width="80%">'; 

  $sqlquery = "select date(logdate) as date,count(*) as count from recentlogs 
         where uname = '$user_name' and date(now())-date(logdate)<7
         group by date(logdate) order by logdate desc limit 5";
         $i = 0;
         $result=$conn->query($sqlquery);
         while($row = mysqli_fetch_array($result)) {
          $result_date[] = $row[0];
          $result_count[] = $row[1];
          $i++;  


    }

    //echo $result_date[0];
  ?>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

         // var uname = '<?php  $user_name; ?>'; 
         // // alert(uname);
         // $.ajax({ url: 'get_recentlogs.php',
         //    data: {uname: uname},
         //    type: 'post',
         //    success: function(out) {                

         //      alert(out.length);
         //       for (var i in out)
         //       {
         //           alert(out[i]);
         //       } 
         //    }

         //  });
         // var date = '<?php echo $result_date[0]; ?>'; 
         //  alert(date);
        var data = google.visualization.arrayToDataTable([
          
          ['Date', 'No. of Requests'],
          ['<?php echo $result_date[4]; ?>',  <?php echo $result_count[4]; ?>],
          ['<?php echo $result_date[3]; ?>',  <?php echo $result_count[3]; ?>],
          ['<?php echo $result_date[2]; ?>',  <?php echo $result_count[2]; ?>],
          ['<?php echo $result_date[1]; ?>',  <?php echo $result_count[1]; ?>],
          ['<?php echo $result_date[0]; ?>',  <?php echo $result_count[0]; ?>],
          
          
          
        ]);

        var options = {
          title: 'Recent Requests',
          // curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

  
  
</head>

<body>
  <div id="curve_chart" style="width: 1300px; height: 400px;padding-left: 27%; padding-bottom: 4%;"></div>
  <hr>
  <div class = 'container'>

</body>
</html>