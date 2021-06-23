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
    <link rel="icon" href="..\img\studylah_logo.jpg" type="image/jpg">
    <link rel="stylesheet" href="..\css\dashboard.css">
    <link rel="stylesheet" href="..\css\navbar.css">
    <title>StudyLah</title>

</head>
<body>
    <!--navbar-->
    <?php include('header.php');?>
    <div class="container">
        <div class="profile">
        <?php
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
                        //display profile picture
                        $profilepic=$rowgetuser['ProfilePic'];
                        if($profilepic=="" || $profilepic==NULL){
                            echo "<div class=profile_pic><a href=\"http://localhost:8080/orbital/profile.php\"><img src=\"..\img/user.png\" alt=\"profilepic\"></a></div>";
                        }
                        else{
                            echo "<div class=profile_pic><a href=\"http://localhost:8080/orbital/profile.php\"><img src=\"../userprofilepic/$profilepic\" alt=\"profilepic\"></a></div>";
                        }
                        //display name, course and year
                        $fullname= $rowgetuser['FullName'];
                        $course= $rowgetuser['Course'];
                        $yearofstudy = $rowgetuser['YearOfStudy'];
                        echo "<div class=info><a href=\"http://localhost:8080/orbital/profile.php\">$fullname <br> $course Year $yearofstudy</a></div>";

                        //$bio = $rowgetuser['Bio'];
                        //if($bio != "" || $bio!=NULL){
                         //   echo "<div class=\"profilebio\"> \" $bio \"</div>";
                        //}
                    }}
        ?>
        </div>

    
        <div class="chats">
             <div class="chat_icon"><a href="../message.php"><img src="../img/chat.png" width="30" height="30" alt="notifications"></a></div>
             <div class="header"><a href="../chats.php">Notifications</a></div>
             <div class="notifications"> There is no notifications.</div>
        </div>


        <div class="schedule"> 
            <span><a href="../schedule.php">Upcoming Meeting</a></span>
            <div class="icon"><a href="../schedule.php"><img src="../img/calendar.png" width="30" height="30" alt="schedule"></a></div>
            <div class="date">
                <?php
                    date_default_timezone_set("Singapore");
                    echo "Today's Date" . "<br>";
                    //echo date("H:i"). "<br>";
                    echo date("l") . "<br>";
                    echo date("d/m/Y") . "<br>";
                ?>
            </div>
            <table id="schedule_list">
                <tr>
                    <th>No.</th>
                    <th>Event</th>
                    <th>Start Time</th>
                    <th>End Time</th>
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

                    $query = "SELECT * FROM schedule WHERE UserID='$id' ORDER BY start_event";

                    if ($result = $mysqli->query($query)) {
                        $number = 1;
                        while ($row = $result->fetch_assoc()) {
                            $title = $row["title"];
                            $start = $row["start_event"];
                            $end = $row["end_event"];
                            echo'
                                <tr> 
                                    <td>'.$number.'</td> 
                                    <td name="task">'.$title.'</td> 
                                    <td name="module">'.$start.'</td> 
                                    <td name="duedate">'.$end.'</td> 
                                </tr>';
                                    
                            $number += 1;
                        }
                        $result->free();
                    }
                    ?>  
            </table>
        </div>

        <div class="checklist">
            <div class="heading">
                <div class="check_icon"><a href="..\addtask.php"><img src=..\img\notes.png width="30" height="30"></a></div>
                <div class="naming"><a href="..\addtask.php">To-Do-List</a></div>
                <div class="add"><button class="open-button"name="add" id="add" onclick="openForm()"><img src=..\img\add.png width="30" height="30"></button></div>
            </div>
                
            <div class="form-popup" id="myForm">
                <form method="post" enctype="multipart/form-data"  class="form-container">
                    <h2>Add A New Task</h2>

                    <label>Module</label><br>
                    <input type="text" name="Module" placeholder="Write Assignment's Module" class="input-field" required>

                    <label>Task</label><br>
                    <textarea name="Tasks" cols="45" rows="3" id="textareabox" placeholder="Description" class="input-field" required></textarea>
                    <br>
                    <br>
                    <label>Due</label><br>
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

                            
                        $url="http://localhost:8080/orbital/dashboard.php/";
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
                        <th>Status</th>
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

                            $query = "SELECT * FROM tasklist WHERE UserID='$id' ORDER BY DueDate";


                            if ($result = $mysqli->query($query)) {
                                $number = 1;
                                while ($row = $result->fetch_assoc()) {
                                    
                                    $tasks = $row["Tasks"];
                                    $module = $row["Modules"];
                                    $duedate = $row["DueDate"];
                                    $duetime = $row["DueTime"];
                                    $completion = $row["Completion"];
                                    $taskid = $row["TaskID"];

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
                            $sql = "DELETE FROM tasklist WHERE TaskID=$taskidno";
                                
                            if ($conn->query($sql) === TRUE) {
                                echo "Record deleted successfully";
                            } else {
                                echo "Error deleting record: " . $conn->error;
                            }
                                
                            $conn->close();

                            $url="http://localhost:8080/orbital/dashboard.php/";
                            header('Location:' . $url);

                            }
                    ?>
                </table>
            </div>
        </div>


        <div class="news" id="new">
            <div class="images">
                <img src="../img/biz.jpg" alt="Business School">
                <img src="../img/bus.jpg" alt="Shuttle Bus">
                <img src="../img/de.jpg" alt="School of Design & Engineering">
                <img src="../img/utown.jpg" alt="U-Town">
                <img src="../img/soc.jpg" alt="School of Computing">
            </div>
        </div>


    <div class="end">
        <button class="nav_contact" >Contact Us</button>
    </div>

    <!--slideshow images-->
    <script>
         var indexValue = 0;
         function slideShow(){
           setTimeout(slideShow, 2000);
           var x;
           const container = document.querySelector("#new")
           const img = container.querySelectorAll("div.images > img");
           for(x = 0; x < img.length; x++){
             img[x].style.display = "none";
           }
           indexValue++;
           if(indexValue > img.length){indexValue = 1}
           img[indexValue -1].style.display = "block";
         }
         slideShow();
    </script>

    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }   

        function clicked(){
            return confirm('Are you sure you have completed the task and finish submission?');
        }
    </script>
</body>
</html>