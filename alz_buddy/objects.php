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
  
  
  if(isset($_POST['btn_add']))                                 
  {
    $obname = $_POST['object_name'];
    $obloc = $_POST['object_location'];

    if($obname == "" || $obloc == "")
    {
      echo "<script type='text/javascript'>alert('Please enter both values in the field.');</script>";
    }
    else
    {
      $query2 = "insert into things values ('$user_name', '$obname', '$obloc')";
      $result = $conn->query($query2);
    }
  }

  ?>
</head>

<body>
  <?php echo '<center><p class="lead" style="padding-top: 15px;">Things</p></center><hr width="80%">';?>
  <br>

  <div>
    <form method="post" class="navbar-form navbar-left" role="search" style="padding-left: 33%; padding-bottom: 4%;">
      <input type="text" class="form-control" placeholder="Thing Name" name="object_name">
      <input type="text" class="form-control" placeholder="Location" name="object_location">
      <button type="submit" class="btn btn-primary" name="btn_add">Add</button>
    </form>
  </div>
  <br>
  <?php echo '<br><hr width = "75%"><br>
              <div class="container"> 
              <table class="table">
                <thead>
                  <tr>
                    <th>Thing Name</th>
                    <th>Thing Location</th>
                  </tr>
                </thead>
                <tbody>';

                $query3 = "select * from things where uname = '$user_name'";
                $result = $conn->query($query3);
                $index = 0;

                while($row_ob = mysqli_fetch_array($result))
                {
                  $index++;
                  echo '<tr>
                    <td><input type="text" class="form-control" value="'.$row_ob[1].'" name="obname" id="obname_'.$index.'" disabled/></td>
                    <td><input type="text" class="form-control" value="'.$row_ob[2].'" name="obloc" id="obloc_'.$index.'" /></td>
                    <td><a href="javascript:click_edit('.$index.');">Update</a></td>
                    <td><a href="javascript:click_delete('.$index.');">Delete</a></td>
                  </tr>';
                }

                echo '</tbody>
              </table>
            </div>';
?>

<script>

function click_edit(index)
{
    var obname = document.getElementById("obname_"+index).value;
    var obloc = document.getElementById("obloc_"+index).value;
    var table = "things";
    var func = "update";
    var uname = "<?php echo $user_name; ?>";

    $.ajax({ url: 'update.php',
        data: {obname: obname, obloc: obloc, table: table, uname: uname, func: func},
        type: 'post',
        success: function(out) {
              //alert(out);
              window.location = "objects.php";

          }
  });

}

function click_delete(index)
{
    var obname = document.getElementById("obname_"+index).value;
    var uname = "<?php echo $user_name; ?>";
    var table = "things";
    var func = "delete";

    $.ajax({ url: 'update.php',
        data: {obname: obname, table: table, uname: uname, func: func},
        type: 'post',
        success: function(out) {
              //alert(out);
              window.location = "objects.php";

          }
  });
}

</script>

</body>
</html>