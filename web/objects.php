<?php
  ini_set('mysql.connect_timeout', 300);
  ini_set('default_socket_timeout', 300);
  error_reporting(0);
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
      form {
        display: inline-block;
        text-align: center !important; 
      }
    </style>

<?php
  session_start();
  require "dbconn.php";
  require "dashboard.php";

  $user_name = $_SESSION['userSession'];
?>
</head>

<body>
  <?php echo '<center><p class="lead" style="padding-top: 15px;">Hello '.$user_name.'</p></center><hr width=50%>';?>
  <br>
  <div>
  <form method="post" class="navbar-form navbar-left" role="search">
      <input type="text" class="form-control" placeholder="Object Name">
      <input type="text" class="form-control" placeholder="Location">
      <button type="submit" class="btn btn-default">Add</button>
  </form>
</div>
<br>
<?php echo '<hr width=50%>';?>
</body>
</html>