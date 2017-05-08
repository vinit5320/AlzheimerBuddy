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
    $name = $_POST['name'];
    $memory = $_POST['memory'];

    if($name == "" || $memory == "" )
    {
      echo "<script type='text/javascript'>alert('Please enter all values in the field.');</script>";
    }
    else
    {
      $query2 = "insert into memories values ('$user_name', '$name', '$memory')";
      $result = $conn->query($query2);
    }
  }

  ?>
</head>

<body>
  <?php echo '<center><p class="lead" style="padding-top: 15px;">Memories</p></center><hr width="80%">';?>
  <br>

  <div>
    <form method="post" class="navbar-form navbar-left" role="search" style="padding-left: 33%; padding-bottom: 4%;">
      <input type="text" class="form-control" placeholder="Person Name" name="name">
      <input type="text" class="form-control" placeholder="Memory" name="memory">
      <button type="submit" class="btn btn-primary" name="btn_add">Add</button>
    </form>
  </div>
  <br>
  <?php echo '<br><hr width = "75%"><br>
              <div class="container"> 
              <table class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Memory</th>
                  </tr>
                </thead>
                <tbody>';

                $query3 = "select * from memories where uname = '$user_name'";
                $result = $conn->query($query3);
                $index = 0;
                while($row_ob = mysqli_fetch_array($result))
                {
                  $index++;
                  echo '<tr>
                    <td><input type="text" class="form-control" value="'.$row_ob[1].'" id="name_'.$index.'" disabled/></td>
                    <td><input type="text" class="form-control" value="'.$row_ob[2].'" id="memory_'.$index.'" /></td>
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
    var name = document.getElementById("name_"+index).value;
    var memory = document.getElementById("memory_"+index).value;
    var table = "memories";
    var func = "update";
    var uname = "<?php echo $user_name; ?>";

    $.ajax({ url: 'update.php',
        data: {name: name, memory: memory, table: table, uname: uname, func: func},
        type: 'post',
        success: function(out) {
              //alert(out);
              window.location = "memories.php";

          }
  });

}

function click_delete(index)
{
    var name = document.getElementById("name_"+index).value;
    var uname = "<?php echo $user_name; ?>";
    var table = "memories";
    var func = "delete";

    $.ajax({ url: 'update.php',
        data: {name: name, table: table, uname: uname, func: func},
        type: 'post',
        success: function(out) {
              //alert(out);
              window.location = "memories.php";

          }
  });
}

</script>

</body>
</html>
