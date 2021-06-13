<?php
@ob_start();
session_start(); 
date_default_timezone_set('Asia/Singapore');
if (!isset( $_SESSION['NUSEmail'] ) ) {
	// Redirect them to the login page
    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
        header("Location: http://localhost/orbital/signup.php");
    }
    else{
        header("Location: http://localhost:8080/orbital/signup.php");
    } 
} 
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img\studylah_logo.jpg" type="image/jpg">
    <link rel="stylesheet" href="css\addtask.css">
    <link rel="stylesheet" href="css\navbar.css">
    
    <title>StudyLah</title>
</head>
<body>
    <nav>
        <div class="logo">StudyLah</div>
        <ul class="nav-links">
        <li><a href="http://localhost:8080/orbital/dashboard.php">Home</a></li>
            <li><a href="http://localhost:8080/orbital/chat.php">Chats</a></li>
            <li><a href="http://localhost:8080/orbital/profile.php">Profile</a></li>
            <li><a href="http://localhost:8080/orbital/logout.php">Logout</a></li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <div class="checklist">
            <div class="heading">
                
                <div class="add"><button class="open-button"name="add" id="add" onclick="openForm()"><img src=img\add.png width="40" height="40"></button></div>
                <div class="naming"><img src=img\notes.png width="30" height="30">To-Do-List</div>
            </div>
                
            <div class="form-popup" id="myForm">
                <form method="post" enctype="multipart/form-data"  class="form-container">
                    <h2>Add A New Task</h2>

                    <label>Module</label><br>
                    <input type="text" name="Module" placeholder="Write Assignment's Module" class="input-field" required>

                    <label>Task</label><br>
                    <textarea name="Tasks" cols="60" rows="3" id="textareabox" placeholder="Description" class="input-field" required></textarea>
                    <br>
                    <br>
                    <label>Deadline</label><br>
                    <input type="date" name="DueDate" required>
                    <input type="time" name="DueTime" required>
                    <br>
                    <br>
                    <button type="submit" class="submit-btn" name="addtaskbtn" id="addtaskbtn">Add</button>
                    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>

                    <?php
                        if (isset($_POST['addtaskbtn'])){ 
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname= "orbital";
                
                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                
                            $useremail=$_SESSION['NUSEmail'];
                            $sqlgetuser="SELECT * FROM users WHERE NUSEmail='$useremail'";
                            $resultgetuser=mysqli_query($conn,$sqlgetuser);
                
                            if(mysqli_num_rows($resultgetuser) > 0){//valid
                                while($rowgetuser=mysqli_fetch_array($resultgetuser)){
                                $id=$rowgetuser['UserID'];
                                }
                            }
                            $taskname=$_POST['Tasks'];
                            $module=$_POST['Module'];
                            $duedate=$_POST['DueDate'];
                            $duetime=$_POST['DueTime'];
                            //insert into checklist
                            $sqlinsert1="INSERT INTO tasklist (UserID,Tasks,Modules,DueDate,DueTime) VALUES ('$id','$taskname','$module', '$duedate', '$duetime');";
                            $result1=mysqli_query($conn,$sqlinsert1);

                            
                        $url="http://localhost:8080/orbital/addtask.php";
                        header('Location:' . $url);

                        }

                    ?>
                </form>
            </div>

            <div class="table">
                <table id="checklist">
                    <tr>
                        <th>No.</th>
                        <th>Task</th>
                        <th>Module</th>
                        <th>Due Date</th>
                        <th>Deadline</th>
                        <th>Complete Status</th>
                    </tr>

                    <?php 
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname= "orbital";

                            $mysqli = new mysqli($servername, $username, $password, $dbname); 
                            
                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error);
                            }
                
                            $useremail=$_SESSION['NUSEmail'];
                            $sqlgetuser="SELECT * FROM users WHERE NUSEmail='$useremail'";
                            $resultgetuser=mysqli_query($mysqli,$sqlgetuser);
                
                            if(mysqli_num_rows($resultgetuser) > 0){//valid
                                while($rowgetuser=mysqli_fetch_array($resultgetuser)){
                                $id=$rowgetuser['UserID'];
                                }
                            }

                            $query = "SELECT * FROM tasklist WHERE UserID='$id'";

                            if ($result = $mysqli->query($query)) {
                                $number = 1;
                                while ($row = $result->fetch_assoc()) {
                                    
                                    $tasks = $row["Tasks"];
                                    $module = $row["Modules"];
                                    $duedate = $row["DueDate"];
                                    $duetime = $row["DueTime"];
                                    $completion = $row["Completion"];
                                    $taskid = $row["Numbering"];

                                    echo '<form method = "post">
                                        <tr> 
                                            <td>'.$number.'</td> 
                                            <td name="task">'.$tasks.'</td> 
                                            <td name="module">'.$module.'</td> 
                                            <td name="duedate">'.$duedate.'</td> 
                                            <td name="duetime">'.$duetime.'</td> 
                                            <td>
                                                <input name = "delete" type = "submit" id="delete" value = "Complete" onclick="return clicked();">
                                            </td>
                                            <td hidden ><input type="hidden" name="taskid" value='.$taskid.'></td>
                                        </tr>
                                        </form>';
                                    
                                    $number += 1;
                                }
                                $result->free();
                            }
                    ?>

                    <?php
                        if(isset($_POST['delete'])) {
                            $taskidno=$_POST['taskid'];

                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname= "orbital";
    
                            $conn = new mysqli($servername, $username, $password, $dbname); 
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                                
                            // sql to delete a record
                            $sql = "DELETE FROM tasklist WHERE Numbering=$taskidno";
                                
                            if ($conn->query($sql) === TRUE) {
                                echo "Record deleted successfully";
                            } else {
                                echo "Error deleting record: " . $conn->error;
                            }
                                
                            $conn->close();

                            $url="http://localhost:8080/orbital/addtask.php";
                            header('Location:' . $url);
                            }
                    ?>
                </table>
            </div>
     </div>

    <div class="end">
        <button class="nav_contact" >Contact Us</button>
    </div>

    <script>
        function clicked(){
            return confirm('Are you sure you have completed the task and finish submission?');
        }
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }   

    </script>
</body>
</html>