<?php

session_start();
require_once('connection.php');
require_once ('department_assoc_array.php');

if(!isset($_SESSION['ldap_id']))
{
    die("Please login first");
}

foreach($_POST as $course_code => $remove)
{
    if($remove == "Remove")
    {
        $query = "DELETE FROM student_applications WHERE course_code='".$course_code."'";
        if(mysqli_query($conn, $query))
        {
            echo "Deleted successfully";
            header("location: my_applications.php");
        }
        else
        {
            echo "There was some error while deleting the entry. Please contact Aman Virani - 9821212128";
            die();
        }
    }   
}


?>
