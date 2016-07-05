<?php

session_start();
require_once 'connection.php';
$ldap_id = $_SESSION['ldap_id'];
$course_code = $_POST['course_code'];


?>
<?php

function make_sop_answers_string()
{
    
}

function get_num_of_current_courses($ldap_id)
{
    $query = "SELECT * FROM student_applications WHERE ldap_id='".$ldap_id."'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}

function get_sop_answers()
{
    $string = "";
    foreach($_POST as $key => $value)
    {
        if(preg_match("/sop_a_\d/", $key))
        {
            if(count($string)==0)
            {
                $string .= $value;
            }
            else
            {
                $string .= ";@;".$value;
            }
        }
    }
    return $string;
}

if($_POST['button']=='Apply for TAship')
{
    if(get_num_of_current_courses($ldap_id)<3)
    {
        $query = "INSERT INTO student_applications (ldap_id, course_code, status_of_application, sop_answers) values ('$ldap_id','$course_code', 'Interview Pending', '".get_sop_answers()."')";
        if(!mysqli_query($conn, $query))
        {
            die("There was some problem applying you for this course. Contact Aman Virani - 9821212128");
        }
    }
    else 
    {
        die("You have already applied for 3 courses. You cannot apply for more than that.");
    }
}

if($_POST['button']=='Accept TAship')
{
    if(get_num_of_current_courses($ldap_id)<3)
    {
        $query = "INSERT INTO student_applications (ldap_id, course_code, status_of_application, sop_answers) values ('$ldap_id','$course_code', 'Interview Pending', '".get_sop_answers()."')";
        if(!mysqli_query($conn, $query))
        {
            die("There was some problem applying you for this course. Contact Aman Virani - 9821212128");
        }
    }
    else 
    {
        die("You have already applied for 3 courses. You cannot apply for more than that.");
    }
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

