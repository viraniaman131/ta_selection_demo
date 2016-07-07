<?php

session_start();
require_once 'connection.php';

// TEMP SOURCE CODE
$_SESSION['ldap_id'] = "sample_ldap";
// END TEMP CODE

$prof_details = NULL;

$query_prof_details = "SELECT * FROM course_info WHERE prof_ldap='".$_SESSION['ldap_id']."'";
$result_query_prof_details = mysqli_query($conn, $query_prof_details);

if(mysqli_num_rows($result_query_prof_details)>0)
{
    while($row = mysqli_fetch_assoc($result_query_prof_details))
    {
        $prof_details = $row;
    }
}

$student_status_set = NULL;

if(!isset($_SESSION['ldap_id']))
{
    die("Please login first!");
}

if(isset($_POST['status']))
{
    //Logic to update DB entry for student application
    
    $query = "UPDATE student_applications SET status_of_application='".$_POST['status']."'"
            . "WHERE ldap_id='".$_POST['student_ldap']."'";
    
    if(mysqli_query($conn, $query))
    {
        $student_status_set = "Successfully set status of ".$_POST['student_name']." to ".$_POST['status']."<br><br>";
    }
    else
    {
        $student_status_set = "Not able to set status! Contact Aman Virani at 9821212128";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Faculty Page</title>
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
                    <li class="active"><a href="faculty.php">View & Edit Student Applications</a></li>
                    <li><a href="edit_course_info.php">Edit Course Information</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            
            <?php
            
            if(!course_is_set())
            {
                echo "<p style='color:red'><a href='edit_course_info.php'>Please set your course details first!</a></p><br>"
                . "Details of students who have applied for your course will show in the table below. Then you can read their"
                        . " SOP answers by clicking on the View SOP button, or set their selection status by choosing from"
                        . " the drop down list. <br><br>";
            }
            
            echo $student_status_set;
            
            ?>
            
            
            
            <table class="table">
                
                <tr>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Year of study</th>
                    <th>CPI</th>
                    <th>Contact Number</th>
                    <th>View SOP</th>
                    <th>Set Selection Status</th>
                </tr>
                
                <?php
                
                $status_options = array("Interview Pending", "Selected", "Rejected", "Waitlisted");
                
                function course_is_set()
                {
                    global $conn;
                    $query = "SELECT * FROM course_info WHERE prof_ldap='".$_SESSION['ldap_id']."'";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result)>0)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                /*
                function get_course_code()
                {
                    global $conn;
                    $query = "SELECT * FROM course_info WHERE prof_ldap='".$_SESSION['ldap_id']."'";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result)>0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            return $row;
                        }
                    }
                    else
                    {
                        return false;
                    }
                }
                 * 
                 */
                
                $query = "SELECT * FROM student_applications WHERE course_code='".$_SESSION['course_code']."'";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)>0)
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        
                        echo "<tr>";
                        
                        $student_name = NULL;
                        $query_student_info = "SELECT * FROM student_details WHERE ldap_id='".$row['ldap_id']."'";
                        $result_query_student_info = mysqli_query($conn, $query_student_info);
                        if(mysqli_num_rows($result_query_student_info))
                        {
                            while($row2 = mysqli_fetch_assoc($result_query_student_info))
                            {
                                echo "<td>".$row2['name']."</td>";
                                echo "<td>".$row2['department']."</td>";
                                echo "<td>".$row2['year_of_study']."</td>";
                                echo "<td>".$row2['cpi']."</td>";
                                echo "<td>".$row2['contact_number']."</td>";
                                
                                $student_name = $row2['name'];
                                
                            }
                        }
                        else
                        {
                            
                        }
                        
                        echo "<td>";
                        echo "<form action='view_student_sop.php' method='post'>"
                        . "<input type='submit' name='view_sop' value='View SOP' />"
                        . "<input type='hidden' name='sop_answers' value='".$row['sop_answers']."' />"
                        . "<input type='hidden' name='sop_questions' value='".$prof_details['sop_questions']."' />"
                        . "<input type='hidden' name='student_name' value='".$student_name."' />"
                        . "</form>";
                        echo "</td>";
                        
                        echo "<td>";
                        echo "<form action='faculty.php' method='post'>"
                        . "<select name='status'>";
                        
                        for($i = 0; $i < 4; $i++)
                        {
                            if($row['status_of_application']==$status_options[$i])
                            {
                                echo "<option selected value='".$status_options[$i]."'>".$status_options[$i]."</option>";
                            }
                            else
                            {
                                echo "<option value='".$status_options[$i]."'>".$status_options[$i]."</option>";
                            }
                        }
                        
                        echo "</select>"
                        . "<input type='hidden' name='student_ldap' value='".$row['ldap_id']."' />"
                        . "<input type='hidden' name='student_name' value='".$student_name."' />"
                        . "<input type='submit' name='set_student_status' value='Set' />"
                        . "</form>";
                        echo "</td>";
                        
                        echo "</tr>";
                        
                    }
                }
                else
                {
                    echo "Please set your course information first!";
                }
                
                ?>
                
            </table>
            
        </div>


    </body>
</html>

