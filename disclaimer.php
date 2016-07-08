<?php

session_start();
require_once("connection.php");

if(!(isset($_POST['button'])))
{
    die("Please apply for a course first");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Section</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
</head>
<body>
    
        

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">TA Selection Portal</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="student.php">All Courses</a></li>
      <li><a href="my_applications.php">My Applications</a></li>
      <li><a href="my_info.php">My Info</a></li>
    </ul>
      <a href="logout.php" class="navbar-brand pull-right">Logout</a>
  </div>
</nav>
  
    <div class="container">
        
        <?php

        /* 
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        $key = 'button';
        $value = $_POST[$key];
        if($value == 'Apply for TAship')
        {
            echo "<h4>Disclaimer</h4>";
            echo "<form action='apply_for_taship.php' method='post'>"
            . "<input type='submit' name='Apply' value='Apply' />"
            . "</form>";
        }
        else if ($value == 'Accept TAship') 
        {
            echo "<h4>Disclaimer</h4>";
            echo "<form action='apply_for_taship.php' method='post'>"
            . "<input type='submit' name='Accept' value='Accept' />"
            . "</form>";
        }
        else if($value == 'Reject TAship')
        {
            echo "<h4>Disclaimer</h4>";
            echo "<form action='apply_for_taship.php' method='post'>"
            . "<input type='submit' name='Reject' value='Reject' />"
            . "</form>";
        }
        else
        {
            echo "Unknown error occured. Please contact Aman Virani - 9821212128.";
            echo "$key => $value";
        }
        

        ?>
        
    </div>
    
</body>
</html>

