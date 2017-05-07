<?php
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
error_reporting(0);

session_start();
require "dbconn.php";

if(!isset($_SESSION['userSession']))
{
	echo "<script type='text/javascript'>alert('You are not logged in! Please log in.');
  window.location = 'index.php';</script>";
}

$user_name = $_SESSION['userSession'];

if(isset($_POST['btn_logout']))
{
  session_destroy();

  $URL="index.php";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
}
?>

<nav class="navbar navbar-default sidebar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">          
        <li ><a href="home.php">Dashboard<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-th-list"></span></a></li>        
        <li ><a href="schedule.php">Schedule<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
        <li ><a href="family.php">Family<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
        <li ><a href="objects.php">Things<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
      </ul>
    </div>
  </div>
  <form method = "post">
    <button type="submit" class="btn btn-primary" name="btn_logout" style="position: absolute; left: 32%; bottom: 2%;">Log out</button>
  </form>
</nav>