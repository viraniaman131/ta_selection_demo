<?php
session_start();
require_once('connection.php');
require_once ('session_details.php');

//require_once('department_assoc_array.php');

/* if(!isset($_SESSION['ldap_id']))
  {
  echo 'hahaha clever guy first login';
  } */

//=====================   TEMP CODE HERE   ===================
$_SESSION['ldap_id'] = '140070009';
//=====================   END OF TEMP CODE HERE   ===================
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
                    <li><a href="student.php">All Courses</a></li>
                    <li><a href="my_applications.php">My Applications</a></li>
                    <li class="active"><a href="my_info.php">My Info</a></li>
                </ul>
                <a href="logout.php" class="navbar-brand pull-right">Logout</a>
            </div>
        </nav>

        <div class="container">
            <h3>All your information is here. Edit as desired</h3>
            <form action="my_info.php" method="post">
                <?php
                
                $query = "SELECT * FROM student_details WHERE ldap_id='".$_SESSION['ldap_id']."'";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)==0)
                {
                    die("User does not exist. Please log in using your LDAP id");
                }
                else
                {
                    while($row = mysqli_fetch_array($result))
                    {
                        echo "<table class='table'>
                                <tr>
                                <th>Name</th>
                                <td>".$row['name']."<td>"
                                . "</tr>"
                                . "<tr>"
                                . "<th>Department</th>"
                                . "<td>".$row['department']."</td>"
                                . "</tr>"
                                . "<th>LDAP ID</th>"
                                . "<td>".$row['ldap_id']."</td>"
                                . "</tr>"
                                . "<tr>"
                                . "<th>Year of study</th>"
                                . "<td><input type='number' name='year_of_study' value='".$row['year_of_study']."'></td>"
                                . "</tr>"
                                . "<tr>"
                                . "<th>CPI</th>"
                                . "<td><input type='text' name='cpi' value='".$row['cpi']."'></td>"
                                . "</tr>"
                                . "<tr>"
                                . "<th>Contact number</th>"
                                . "<td><input type='text' name='contact_number' value='".$row['contact_number']."'></td>"
                                . "</tr>"
                                . "</table>";
                    }
                }
                
                ?>
                <input type="submit" value="Update Information" style="float: right"/>
                
            </form>
                
        </div>

    </body>
</html>
<?php

//Script to handle the post requests to change info

if(isset($_POST['cpi'])||isset($_POST['year_of_study'])||isset($_POST['contact_number']))
{
    $query = "UPDATE student_details SET cpi='".$_POST['cpi']."', year_of_study='".$_POST['year_of_study']."', contact_number='".$_POST['contact_number']."' WHERE ldap_id='".$_SESSION['ldap_id']."'";
    if(mysqli_query($conn, $query))
    {
        header("location: my_info.php");
    }
    else
    {
        die(mysqli_error($conn));
    }
}


?>

