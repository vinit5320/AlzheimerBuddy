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
</head>

<body>
  <?php
  session_start();
  require "dbconn.php";
  require "dashboard.php";

  $user_name = $_SESSION['userSession'];

  $query = $conn->query("select * from personal where user_name = '$user_name'");
  $count_rows = $query->num_rows;
  $row = $query->fetch_array();
  
  if(isset($_POST['btn_save']))                                 
  {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $home_add = $_POST['home_add'];

    if($count_rows == 0)
    {
      $sqlquery = "insert into personal values ('$user_name', '$name', '$dob', '$contact', '$home_add')";
      $result = $conn->query($sqlquery);
    }
    else
    {
      $sqlquery = $conn->query("update personal set pname = '$name', dob = '$dob', contact = '$contact', home = '$home_add' 
        where user_name = '$user_name'");

    }
    echo '<script>
      window.location = "personal_info.php";
      </script>';
  }

  ?>



  <?php echo '<center><p class="lead" style="padding-top: 15px;">Personal Information</p></center><hr width="80%">';?>
  <div class="container">
    
  <form method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="row">
      
          <!-- edit form column -->
          <div class="col-md-9 personal-info">
        
            <div class="form-group">
            <label class="col-lg-3 control-label">Name:</label>
              <div class="col-lg-4">
                <input class="form-control" type="text" value="<?php echo $row['pname']; ?>" required="" name="name">
              </div>
            </div>
          
            <div class="form-group">
            <label class="col-lg-3 control-label">Date of Birth:</label>
              <div class="col-lg-4">
                <input class="form-control" type="date" value="<?php echo $row['dob']; ?>" required="" name="dob">
              </div>
           </div>
          
            <div class="form-group">
            <label class="col-lg-3 control-label">Contact:</label>
              <div class="col-lg-4">
                <input class="form-control" type="text" value="<?php echo $row['contact']; ?>" required="" name="contact">
              </div>
            </div>
          
            <div class="form-group">
            <label class="col-md-3 control-label">Home address:</label>
              <div class="col-md-8">
                <input class="form-control" type="text" value="<?php echo $row['home']; ?>" required="" name="home_add">
              </div>
            </div>

            <div class="form-group">
            <label class="col-md-3 control-label"></label>
              <div class="col-md-4">
                <button type="Submit" class="btn btn-info" style="margin-right: 15px;" name="btn_save">Save Changes</button>
                <span></span>
                <a href="user_profile.php"><button type="button" class="btn btn-default">Cancel</button></a>
              </div>
            </div>
        
      </div>
  </div>
  </form>
</div>

</body>
</html>