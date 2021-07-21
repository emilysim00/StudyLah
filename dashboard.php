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
<style>
    .logoutbutton{
        vertical-align:middle;
        background-color: #5d4954;
        color:white;
        border:none;
    }

    .logoutbutton:hover{
        cursor:pointer;
        opacity:0.7;
    }

    a {
        text-decoration: none;
    }

    ul {
        list-style: none;
        margin: 0;
        padding-left: 0;
    }

    li {
        color: #fff;
        display: block;
        float: left;
        padding: 1rem;
        position: relative;
        text-decoration: none;
        transition-duration: 0.5s;
    }
    
    li a {
        color: #fff;
    }

    li:hover {
        background: #424240;
        cursor: pointer;
    }

    ul li ul {
        background: #5d4954;
        visibility: hidden;
        opacity: 0;
        min-width: 5rem;
        position: absolute;
        transition: all 0.5s ease;
        margin-top: 1rem;
        left: 0;
        display: none;
    }

    ul li:hover > ul,
    ul li ul:hover {
        visibility: visible;
        opacity: 1;
        display: block;
    }

    ul li ul li {
        clear: both;
        width: 100%;
    }
</style>

<body>
    <!--navbar-->
    <nav>
        <div class="logo">StudyLah</div>
        <ul class="nav-links">
            <li>
                <?php
                //search
                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                    echo "<a href=\"http://localhost/orbital/searchusers.php\"><img src=\"../img/search-white.png\" width=\"20px\" height=\"20px;\" alt=\"Search\"></a>";
                }
                else{
                    echo "<a href=\"http://localhost:8080/orbital/searchusers.php\"><img src=\"../img/search-white.png\" width=\"20px\" height=\"20px;\" alt=\"Search\"></a>";
                } 
                ?>
            </li>
            <li>
                <?php
                //Home
                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                    echo "<a href=\"http://localhost/orbital/dashboard.php/\">Home</a>";
                }
                else{
                    echo "<a href=\"http://localhost:8080/orbital/dashboard.php/\">Home</a>";
                } 
                ?>
            </li>
            <li>
                <?php
                //Messages
                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                    echo "<a href=\"http://localhost/orbital/message.php\">Chats</a>";
                }
                else{
                    echo "<a href=\"http://localhost:8080/orbital/message.php\">Chats</a>";
                } 
                ?>
            </li>
            <li>
                <?php
                //Profile
                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                    echo "<a href=\"http://localhost/orbital/profile.php\">Profile</a>";
                }
                else{
                    echo "<a href=\"http://localhost:8080/orbital/profile.php\">Profile</a>";
                } 
                ?>
            </li>

            <li><a href="#">Others</a>
            <ul class="dropdown">
                <li>
                    <?php
                    //forum
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/forum.php\">Forum</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/forum.php\">Forum</a>";
                    } 
                    ?>
                </li>
                <li>
                    <?php
                    //Schedule
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/schedule.php\">Add Schedule</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/schedule.php\">Add Schedule</a>";
                    } 
                    ?>
                </li>
                <li>
                    <?php
                    //add tasks
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/addtask.php\">Add Task</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/addtask.php\">Add Tasks</a>";
                    } 
                    ?>
                </li>
                <li>
                    <?php
                    //locations
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/recommendations.php\">Locations Recommendation</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/recommendations.php\">Locations Recommendation</a>";
                    } 
                    ?>
                </li>
            </ul>
            </li>

            <li>
                <form method="post">
                    <button type="submit" name="logout" class="logoutbutton">
                        <img src="../img/logout.png" width="20px" height="20px" alt="logout">
                    </button>
                <?php
                    if(isset($_POST['logout'])){
                        session_destroy();
                        unset($_SESSION['NUSEmail']);
                        
                        if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                            $url="http://localhost/orbital/signup.php";
                            header('Location:' . $url);
                        }
                        else{
                            $url="http://localhost:8080/orbital/signup.php";
                            header('Location:' . $url);
                        } 
                    }
                ?>
                </form>
            </li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>
    <script src="js\app.js"></script>
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

                            
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                $url="http://localhost/orbital/dashboard.php/";
                                header('Location:' . $url);
                            }
                            else{
                                $url="http://localhost:8080/orbital/dashboard.php/";
                                header('Location:' . $url);
                            } 
                        
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

                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                $url="http://localhost/orbital/dashboard.php/";
                                header('Location:' . $url);
                            }
                            else{
                                $url="http://localhost:8080/orbital/dashboard.php/";
                                header('Location:' . $url);
                            }

                            }
                    ?>
                </table>
            </div>
        </div>
        
        <div class="forum">
            <div class="chat_icon"><a href="../forum.php"><img src="../img/discussion.png" width="30" height="30" alt="notifications"></a></div>
            <div class="header"><a href="../forum.php">Forum</a></div>
            <div class="table">
                <table id="checklist">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th></th>
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
                        $query = "SELECT * FROM forum WHERE ReplyToID='0'";

                        if ($result = $mysqli->query($query)) {
                            while ($row = $result->fetch_assoc()) {  
                            $title = $row["Title"];
                            $message = $row["Message"];
                            $forumid = $row["ForumID"];
                            $link = "http://localhost:8080/orbital/viewforum.php?forum=".$forumid;
        
                            echo '
                                <tr> 
                                <td name="task">'.$title.'</td> 
                                <td name="module">'.$message.'</td> 
                                <td>
                                    <button class="reply"><a href='.$link.'>Reply</a></button>
                                </td>
                                </tr>
                                ';
                                }
                            $result->free();
                            }
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
           setTimeout(slideShow, 2800);
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
