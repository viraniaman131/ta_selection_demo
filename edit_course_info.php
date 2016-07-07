<?php

session_start();
require_once 'connection.php';

if(!isset($_SESSION['ldap_id']))
{
    die("Please login first!");
}

$course_info = array();

$query = "SELECT * FROM course_info WHERE prof_name='".$_SESSION['prof_name']."'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result)>0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        $course_info = $row;
    }
}

$_SESSION['course_code'] = $course_info['course_code'];

$sop_questions = explode(";@;", $course_info['sop_questions']);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Course Information</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
        $(function() 
        {
            $( "#datepicker" ).datepicker();
        });
        $(function() 
        {
            $( "#datepicker2" ).datepicker();
        });
        $(function() 
        {
            $( "#datepicker3" ).datepicker();
        });
        </script>
        
        <script>
            
        Element.prototype.remove = function() 
        {
            this.parentElement.removeChild(this);
        }
        NodeList.prototype.remove = HTMLCollection.prototype.remove = function() 
        {
            for(var i = this.length - 1; i >= 0; i--) 
            {
                if(this[i] && this[i].parentElement) 
                {
                    this[i].parentElement.removeChild(this[i]);
                }
            }
        }
        
        function add_fields()
        {
            // Number of inputs to create
            
            var i = document.getElementById('num_q').value;
            j = parseInt(i);
            var container = document.getElementById('container2');
            var text = document.createTextNode("Question " + (j+1) + ": ");
            var para = document.createElement('p');
            para.appendChild(text);
            para.id = 'sop_q_p_'+j;
            container.appendChild(para);
            // Create an <input> element, set its type and name attributes
            var input = document.createElement("input");
            input.type = "text";
            input.name = "sop_q_" + (j);
            input.id = "sop_q_" + (j);
            input.size = '60';
            container.appendChild(input);
            // Append a line break 
            var br = document.createElement("br");
            br.id = 'sop_q_br_'+j;
            container.appendChild(br);
            j+=1;
            document.getElementById('num_q').value = j.toString();
            
        }
        
        function remove_field()
        {
            var i = document.getElementById('num_q').value;
            var j = parseInt(i)-1;        
            if(j < 1)
            {
                return false;
            }
            document.getElementById('sop_q_'+j).remove();
            document.getElementById('sop_q_p_'+j).remove();
            document.getElementById('sop_q_br_'+j).remove();
            document.getElementById('num_q').value = j;
            console.log("Value of num_q = "+j)
            
        }
        
        </script>
        
    </head>
    <body>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">TA Selection Portal</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="faculty.php">View & Edit Student Applications</a></li>
                    <li class="active"><a href="edit_course_info.php">Edit Course Information</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            
            <?php
            
            if($_SESSION['course_info_edit_successful'] == 1)
            {
                echo "<p style='color:red'>Details successfully updated!</p><br/>";
                $_SESSION['course_info_edit_successful'] = 0;
            }
            
            ?>
            
            <form action="submit_course_details.php" method="post">            
            <table class="table">
                <tr>
                    <th>
                        Course Code:
                    </th>
                    <td>
                        <?php 
                        
                        if($course_info['course_code'] != '' && $course_info['course_code'] != NULL)
                        {
                            echo "<input type='text' name='course_code' value='".$course_info['course_code']."' readonly/>";
                        }
                        else
                        {
                            echo "<input type='text' name='course_code' value='".$course_info['course_code']."'/>";
                        }
                        
                        
                        ?>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        Course Name:
                    </th>
                    <td>
                        <?php echo "<input type='text' name='course_name' value='".$course_info['course_name']."'/>";?>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        Application Deadline for TAship:
                    </th>
                    <td>
                        <?php echo "<input type='text' name='deadline' value='".$course_info['deadline']."' id='datepicker'/>";?>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        Eligibility Criteria:
                    </th>
                    <td>
                        <?php echo "<input type='text' name='eligibility_criteria' value='".$course_info['eligibility_criteria']."'/>";?>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        Course Details:
                    </th>
                    <td>
                        <?php echo "<textarea cols='30' rows='3' name='course_details'>".$course_info['course_details']."</textarea>";?>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        Interviews Start Date:
                    </th>
                    <td>
                        <?php echo "<input type='text' name='interview_start_date' value='".$course_info['interview_start_date']."' id='datepicker2'/>";?>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        Interviews End Date:
                    </th>
                    <td>
                        <?php echo "<input type='text' name='interview_end_date' value='".$course_info['interview_end_date']."' id='datepicker3'/>";?>
                    </td>
                </tr>
                
                <tr>
                    <th>
                    </th>
                </tr>
                
                
                
            </table>
                
            <input type="submit" name="save_course_info" value="Save Course Information" class="btn" style="float:right"/>
            
            <h3>Enter SOP Questions here:</h3>
            
            <div id="container2">
                <?php
                
                echo "<input type='hidden' id='num_q' value='".count($sop_questions)."' />";
                
                if(count($sop_questions) > 0)
                {
                    for($i = 0; $i < count($sop_questions); $i++)
                    {
                        echo "<p id='sop_q_p_$i' >Question ".($i+1).": </p><input type='text' size='60' name='sop_q_$i' value='$sop_questions[$i]' id='sop_q_$i'/><br/>";  
                    }
                }
                else
                {
                    echo "<p id='sop_q_p_0'>Question 1: </p><input type='text' size='60' name='sop_q_0' id='sop_q_0'/><br/>";  
                }
                
                ?>
                
                
                
            </div>
            </form>
            
            <button id="add_q_btn" onclick="add_fields()">Add Another Question</button>
            <button id="remove_q_btn" onclick="remove_field()">Remove Last Question</button>
            
        </div>


    </body>
</html>

