<?php
session_start();
require_once('connection.php');

var_dump($_POST);
echo "\n";
var_dump($_SESSION);

foreach($_POST as $course_code => $key)
{
    $ldap_id = $_SESSION['ldap_id'];
    $check_query = "SELECT * FROM student_applications WHERE course_code='".$course_code."'";
    
    $result1 = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($result1)>0)
    {
        echo "Database error. You may have already applied for this course. Please select another course if you want to apply. In case you are seeing this error without any apparent reason, please contact Aman Virani at 9821212128.";
    }
    else
    {
        $query = "INSERT INTO student_applications (ldap_id, course_code, status_of_application) VALUES ('".$ldap_id."', '".$course_code."', 'Interview Pending')";
        if(mysqli_query($conn, $query))
        {
            header('location: my_applications.php');
        }
        else
        {
            echo "Couldn't process your request. Please contact Aman Virani at 9821212128";
        }
    }
}

?>
