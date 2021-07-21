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
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="icon" href="img\studylah_logo.jpg" type="image/jpg">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css\navbar.css">
    <link rel="stylesheet" href="css\message.css">
    <link rel="stylesheet" href="css\seemessage.css">
    <meta http-equiv="refresh" content="40" /><!--reload page every 40 seconds-->
    <title>StudyLah</title>
</head>
<body style="font-family:'Inter',sans-serif;" onload="updateScroll()">
    <!--navbar-->
    <?php include('header.php');?>
    <!--message section-->
    <section style="background-color:#424240;">
        <section id="messagesection">
            <div>
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

                $timestamp=date('Y-m-d H:i:s');//timestamp format

                //check whether person in group - authentication
                $fetchgroup=$_GET['group'];
                $currentuseremail=$_SESSION['NUSEmail'];
                $fontcolorarrayusers = array();//fpr setting font color of different users
                $fontcolors = array();

                for ($x = 0; $x <= 300; $x++){//max number can be changed
                    $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);//generate 6 hex no.
                    $addhashtag = '#'.$rand;
                    array_push($fontcolors,$addhashtag);//to add in color - yellow, purple, red, blue, lightgreen, darkgreen
                }

                $sqlfetchgroup = "SELECT * FROM messages WHERE GroupID='$fetchgroup' AND NUSEmail='$currentuseremail'";
                $resultfetchgroup=mysqli_query($conn,$sqlfetchgroup);

                if(mysqli_num_rows($resultfetchgroup) > 0){//valid message, or in valid group
                    while($rowfetchgroup=mysqli_fetch_array($resultfetchgroup)){//continue viewing message
                        
                        $sqlfetchgroupdetails = "SELECT * FROM groups WHERE GroupID='$fetchgroup'";
                        $resultfetchgroupdetails=mysqli_query($conn,$sqlfetchgroupdetails);

                        if(mysqli_num_rows($resultfetchgroupdetails) > 0){//valid group, group exists
                            while($rowfetchgroupdetails=mysqli_fetch_array($resultfetchgroupdetails)){
                                //first, change message status to seen
                                $sqlupdateseen = "UPDATE notifications SET Status='Seen' WHERE GroupID='$fetchgroup' AND NUSEmail='$currentuseremail'";
                                $resultupdateseen = mysqli_query($conn,$sqlupdateseen);

                                $groupname = $rowfetchgroupdetails['GroupName'];
                                $grouppic = $rowfetchgroupdetails['GroupPic'];
                                
                                echo "<div id=\"groupdetails\">";
                                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                    echo "<div class=\"backbutton\" onclick=\"window.location.href='http://localhost/orbital/message.php'\"><img src=\"img/back.png\" width=\"15px\" height=\"15px\" class=\"backpic\">Back</div>";//back button
                                }
                                else{
                                    echo "<div class=\"backbutton\" onclick=\"window.location.href='http://localhost:8080/orbital/message.php'\"><img src=\"img/back.png\" width=\"15px\" height=\"15px\" class=\"backpic\">Back</div>";//back button
                                }
                                if ($grouppic == "" || $grouppic == NULL) {
                                    echo "<div><img src=\"img/user.png\" width=\"100px\" height=\"100px\" id=\"grouppicture\"></div>";
                                }
                                else{
                                    echo "<div><img src=\"grouppic/$grouppic\" width=\"100px\" height=\"100px\" id=\"grouppicture\"></div>";
                                }
                                echo "<div id = \"groupdetailsname\">$groupname</div>";
                                //show members of the group
                                $sqlshowmembers = "SELECT * FROM messages WHERE GroupID='$fetchgroup' GROUP BY NUSEmail";
                                $resultshowmembers = mysqli_query($conn,$sqlshowmembers);

                                echo "<div class=\"showgroupmembers\">";
                                while($rowshowmembers = mysqli_fetch_array($resultshowmembers)){
                                    $themembers = $rowshowmembers['FullName'];
                                    echo "$themembers".",&nbsp";
                                }
                                echo "</div>";

                                //add group schedule
                                echo "<p>Group Schedule</p><div class=\"lineseparator\"><button id=\"addgroupschedule\">+ Add a group schedule</button><button id=\"viewgroupschedule\">View group schedule</button></div>";
                                echo "<p>Group Task</p><div class=\"lineseparator\"><button id=\"addgrouptask\">+ Add a group task</button><button id=\"viewgrouptask\">View group task</button></div><br><br>";
                                echo "<hr>";
                                echo "</div>";
                               
                                //now display the messages chat
                                $sqlgetmessages = "SELECT * FROM messages WHERE GroupID='$fetchgroup' ORDER BY MessageID ASC";
                                $resultgetmessages= mysqli_query($conn,$sqlgetmessages);
                                echo "<div class =\"thefinalchatbox\" id=\"thefinalchatbox\">";
                                while($rowgetmessages=mysqli_fetch_array($resultgetmessages)){
                                    $themessages = $rowgetmessages['Message'];
                                    $theuseremail = $rowgetmessages['NUSEmail'];

                                    $theusertiming = $rowgetmessages['Timing'];
                                    if ($themessages != "" || $themessages != NULL){//display if not empty message
                                        if($theuseremail == $currentuseremail){//current user: float message box to right
                                            echo "<div class=\"currentusermessage\">";
                                            echo "<div class=\"metext\">Me</div>";
                                            echo $themessages;
                                            echo "<br><br><div class=\"timestamp\">$theusertiming</div>";
                                            echo "</div>";
                                            echo "<div class=\"clearfloats\"></div>";
                                        }
                                        else{//other ppl : float message box to left
                                            
                                            //check if existing in font colors array
                                            if(!in_array($theuseremail,$fontcolorarrayusers)){//not in array, then
                                                array_push($fontcolorarrayusers,$theuseremail);//push into array
                                            }
                                            echo "<div class=\"otherusermessage\">";
                                            $arrayindex = array_search($theuseremail,$fontcolorarrayusers);
                                            //echo $fontcolors[$arrayindex];
                                            $thecolour = $fontcolors[$arrayindex];
                                            echo "<div class=\"otherusertext\" style=\"color:$thecolour\">".$rowgetmessages['FullName']."</div>";
                                            echo $themessages;
                                            echo "<br><br><div class=\"timestamp\">$theusertiming</div>";
                                            echo "</div>";
                                        }
                                    }
                                }

                                echo "</div>";

                                //now the chat box
                                echo "<div id=\"chatbox\">";
                                echo "<form method=\"post\">";
                                echo "<textarea cols=\"70\" rows=\"5\" placeholder=\"Type a message\" name=\"sentmessage\"></textarea>";
                                echo "&nbsp&nbsp<button type=\"submit\" name=\"mychatbutton\" id=\"mychatbutton\">Send</button>";
                                echo "</form>";
                                echo "</div>";

                                if (isset($_POST['mychatbutton'])){
                                    //insertinto messages
                                    $themessagetobesent = $_POST['sentmessage'];

                                    //sanitize input
                                    $themessagetobesent = mysqli_real_escape_string($conn,$themessagetobesent);
                                    $themessagetobesent = filter_var($themessagetobesent, FILTER_SANITIZE_STRING);

                                    //first get the user full name and id
                                    $sqlgetnameid = "SELECT * FROM users WHERE NUSEmail = '$currentuseremail'";
                                    $resultgetnameid = mysqli_query($conn,$sqlgetnameid);

                                    while($rowgetnameid=mysqli_fetch_array($resultgetnameid)){
                                        $theusername = $rowgetnameid['FullName'];
                                        $theuserid = $rowgetnameid['UserID'];

                                        //insert into message
                                        $sqlinsertmessage="INSERT INTO messages (UserID,GroupID,NUSEmail,FullName,Message,Timing)
                                        VALUES ('$theuserid','$fetchgroup','$currentuseremail','$theusername','$themessagetobesent','$timestamp')";
                                        $resultinsertmessage = mysqli_query($conn,$sqlinsertmessage);

                                        //insert notifications for others - dont insert for myself... but first, determine how many notifications to insert
                                        $sqlgetothers="SELECT * FROM messages WHERE GroupID='$fetchgroup' AND NOT NUSEmail='$currentuseremail' GROUP BY NUSEmail";
                                        $resultgetothers = mysqli_query($conn,$sqlgetothers);

                                        while($rowgetothers=mysqli_fetch_array($resultgetothers)){
                                            $getotheremails=$rowgetothers['NUSEmail'];

                                            //now insert into notifications
                                            $sqlinsertnotificationmessage = "INSERT INTO notifications (GroupID,NUSEmail,NotificationType,Timing,Status,Message)
                                            VALUES ('$fetchgroup','$getotheremails','Message','$timestamp','Unseen','New message from $groupname')";
                                            $resultinsertnotificationmessage=mysqli_query($conn,$sqlinsertnotificationmessage);
                                        }

                                        //once message and notifications inserted redirect/refresh
                                        if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                            $url="http://localhost/orbital/seemessage.php?group=$fetchgroup";
                                            header('Location:' . $url);
                                        }
                                        else{
                                            $url="http://localhost:8080/orbital/seemessage.php?group=$fetchgroup";
                                            header('Location:' . $url);
                                        }
                                    }
                                    
                                }
                            }
                            break;//display once only
                        }
                        else{
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                $url="http://localhost/orbital/error.php?error=unauthorizedgroup";
                                header('Location:' . $url);
                            }
                            else{
                                $url="http://localhost:8080/orbital/error.php?error=unauthorizedgroup";
                                header('Location:' . $url);
                            }
                        }
                    }
                }
                else{
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        $url="http://localhost/orbital/error.php?error=unauthorizedgroup";
                        header('Location:' . $url);
                    }
                    else{
                        $url="http://localhost:8080/orbital/error.php?error=unauthorizedgroup";
                        header('Location:' . $url);
                    }
                }

                ?>
            </div>
            
            <!--Modal box for add group schedules-->
            <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="post">
                    <p style="font-weight:bold;text-decoration:underline;margin-bottom:15px;">Set a group schedule for everyone:<p>
                    <p>Group: 
                        <?php 

                        $sqlgetgroup = "SELECT * FROM groups WHERE GroupID='$fetchgroup'";
                        $resultgetgroup = mysqli_query($conn, $sqlgetgroup);
                        while($rowgetgroup=mysqli_fetch_array($resultgetgroup)){
                            $thegroupname = $rowgetgroup['GroupName'];
                            echo $thegroupname;
                            echo "<input type=\"text\" value=\"$thegroupname\" name=\"groupScheduleName\" required hidden>";
                        }
                        ?>
                    </p>
                    <table id="groupScheduleTable">
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="groupScheduleTitle" required></td>
                    </tr>
                    <tr>
                        <td>Location:</td>
                        <td><input type="text" name="groupScheduleLocation" required></td>
                    </tr>
                    <tr>
                        <td>Start: </td>
                        <td><input type="date" name="groupScheduleStartDate" required><input type="time" name="groupScheduleStartTime" required></td>
                    </tr>
                    <tr>
                        <td>End:</td> 
                        <td><input type="date" name="groupScheduleEndDate" required><input type="time" name="groupScheduleEndTime" required></td>
                    </tr>
                    </table>
                    <br>
                    <button type="submit" name="groupScheduleSubmit" id="groupScheduleButton">Confirm Schedule</button>
                </form>
                <?php

                //add into schedule
                if(isset($_POST['groupScheduleSubmit'])){
                    $groupscheduletitle = $_POST['groupScheduleName']." - ".$_POST['groupScheduleTitle'];
                    $groupschedulelocation = $_POST['groupScheduleLocation'];
                    $groupschedulestart = $_POST['groupScheduleStartDate']." ".$_POST['groupScheduleStartTime'];
                    $groupscheduleend = $_POST['groupScheduleEndDate']." ".$_POST['groupScheduleEndTime'];
                    $thefinalstarttime = date("Y-m-d H:i:s",strtotime($groupschedulestart));
                    $thefinalendtime = date("Y-m-d H:i:s",strtotime($groupscheduleend));
                    echo $thefinalendtime;

                    //sanitize
                    $groupscheduletitle = mysqli_real_escape_string($conn, $groupscheduletitle);
                    $groupschedulelocation = mysqli_real_escape_string($conn,$groupschedulelocation);

                    $groupscheduletitle = filter_var($groupscheduletitle, FILTER_SANITIZE_STRING);
                    $groupschedulelocation = filter_var($groupschedulelocation, FILTER_SANITIZE_STRING);

                    //first get the people in the group uniquely
                    $sqlgetpeoplefromgroup = "SELECT * FROM messages WHERE GroupID='$fetchgroup' GROUP BY NUSEmail";//or can grp by user id
                    $resultgetpeoplefromgroup = mysqli_query($conn,$sqlgetpeoplefromgroup);

                    while($rowgetpeoplefromgroup = mysqli_fetch_array($resultgetpeoplefromgroup)){
                        $eachuserID = $rowgetpeoplefromgroup['UserID'];

                        //now insert into everyone's schedule
                        $sqlinsertintoschedule = "INSERT INTO schedule (UserID,title, venue,start_event,end_event)
                        VALUES ('$eachuserID','$groupscheduletitle','$groupschedulelocation','$thefinalstarttime','$thefinalendtime')";
                        $resultinsertintoschedule = mysqli_query($conn,$sqlinsertintoschedule);
                    }

                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        header("Location: http://localhost/orbital/groupschedulesuccess.php?g=$fetchgroup");
                    }
                    else{
                        header("Location: http://localhost:8080/orbital/groupschedulesuccess.php?g=$fetchgroup");
                    }
                }
                ?>
            </div>
            </div>

            <!--Modal for view schedules-->
            <!-- The Modal -->
            <div id="myModal2" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                <span class="close2">&times;</span>
                    <div>
                        <?php
                        //first get user id
                        $sqlgetuserid = "SELECT * FROM users WHERE NUSEmail = '$currentuseremail'";
                        $resultgetuserid= mysqli_query($conn,$sqlgetuserid);
                        $tablenumbering = 0;
                        while($rowgetuserid = mysqli_fetch_array($resultgetuserid)){
                            $theid = $rowgetuserid['UserID'];

                            //now fetch the schedule for the user ID
                            $sqlgetschedule = "SELECT * FROM schedule WHERE UserID='$theid' ORDER BY start_event ASC";//order by date
                            $resultgetschedule = mysqli_query($conn,$sqlgetschedule);
                            echo "<div style=\"font-weight:bold;text-decoration:underline;padding:20px;\">Group Schedules</div>";

                            if(mysqli_num_rows($resultgetschedule) > 0){//valid, got schedule
                                echo "<table id=\"viewscheduletable\">";
                                echo "<tr><td>No.</td><td>Title</td><td>Location</td><td>Start Date</td><td>End Date</td><td>Action</td></tr>";
                                while($rowgetschedule = mysqli_fetch_array($resultgetschedule)){
                                    $gettitleschedule = $rowgetschedule['title'];

                                    //fetch current group name first
                                    $sqlfetchcurrentgroup = "SELECT * FROM groups WHERE GroupID='$fetchgroup'";
                                    $resultfetchcurrentgroup = mysqli_query($conn,$sqlfetchcurrentgroup);

                                    while($rowfetchcurrentgroup = mysqli_fetch_array($resultfetchcurrentgroup)){
                                        $currgroupname = $rowfetchcurrentgroup['GroupName'];

                                        //compare group name with title (get the title with the group name in it)

                                        if (strpos($gettitleschedule, $currgroupname) !== false){// if exists in that string, then display that schedule
                                            $tablenumbering += 1;
                                            $thescheduletitle= $rowgetschedule['title'];
                                            $theschedulelocation = $rowgetschedule['venue'];
                                            $starttime = $rowgetschedule['start_event'];
                                            $starttimeformatted = date('d/m/Y H:i', strtotime($starttime));
                                            $endtime = $rowgetschedule['end_event'];
                                            $endtimeformatted = date('d/m/Y H:i', strtotime($endtime));
                                            echo "<tr>";
                                            echo "<td>$tablenumbering</td>
                                            <td>$thescheduletitle</td>
                                            <td>$theschedulelocation</td>
                                            <td>$starttimeformatted</td>
                                            <td>$endtimeformatted</td>
                                            <td>
                                            <form method=\"post\"><input type=\"text\" value=\"$thescheduletitle\" name=\"doneScheduleName\" required hidden>
                                            <button type=\"submit\" name=\"doneSchedule\" id=\"doneSchedule\">Done for everyone</button>
                                            </form>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    }
                                }
                                echo "</table>";
                            }
                            else{
                                echo "<p>No schedules yet for this group...</p>";
                            }
                        }

                        //done schedule button
                        if(isset($_POST['doneSchedule'])){
                            $doneschedulename = $_POST['doneScheduleName'];
                            $doneschedulename = mysqli_real_escape_string($conn,$doneschedulename);
                            $doneschedulename = filter_var($doneschedulename, FILTER_SANITIZE_STRING);

                            //get that event from database
                            $sqlgetevent  = "SELECT * FROM schedule";
                            $resultgetevent = mysqli_query($conn,$sqlgetevent);

                            while($rowgetevent = mysqli_fetch_array($resultgetevent)){
                                $theevent = $rowgetevent['title'];

                                if ($theevent == $doneschedulename){//matches db, then delete
                                    $gettheid = $rowgetevent['ScheduleID'];
                                    $sqldeleteevent = "DELETE FROM schedule WHERE ScheduleID='$gettheid'";
                                    $resultdeleteevent = mysqli_query($conn,$sqldeleteevent);

                                    //redirect
                                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                        header("Location: http://localhost/orbital/groupschedulesuccess.php?g=$fetchgroup");
                                    }
                                    else{
                                        header("Location: http://localhost:8080/orbital/groupschedulesuccess.php?g=$fetchgroup");
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!--modal for add group task-->
            <!-- The Modal -->
            <div id="myModal3" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                <span class="close3">&times;</span>
                <form method="post">
                    <p style="font-weight:bold;text-decoration:underline;margin-bottom:15px;">Set a group task for everyone:<p>
                    <p>Group: 
                        <?php 

                        $sqlgetgroup2 = "SELECT * FROM groups WHERE GroupID='$fetchgroup'";
                        $resultgetgroup2 = mysqli_query($conn, $sqlgetgroup2);
                        while($rowgetgroup2=mysqli_fetch_array($resultgetgroup2)){
                            $thegroupname2 = $rowgetgroup2['GroupName'];
                            echo $thegroupname2;
                            echo "<input type=\"text\" value=\"$thegroupname2\" name=\"groupTaskName\" required hidden>";
                        }
                        ?>
                    </p>
                    <table id="groupTaskTable">
                    <tr>
                        <td>Task Title:</td>
                        <td><input type="text" name="groupTaskTitle" required></td>
                    </tr>
                    <tr>
                        <td>Modules:</td>
                        <td><input type="text" name="groupTaskModules" required></td>
                    </tr>
                    <tr>
                        <td>Due: </td>
                        <td><input type="date" name="groupTaskDueDate" required><input type="time" name="groupTaskDueTime" required></td>
                    </tr>
                    </table>
                    <br>
                    <button type="submit" name="groupTaskSubmit" id="groupTaskButton">Confirm Task</button>
                </form>
                <?php

                //add into task
                if(isset($_POST['groupTaskSubmit'])){
                    $grouptasktitle = $_POST['groupTaskName']." - ".$_POST['groupTaskTitle'];
                    $grouptaskmodules = $_POST['groupTaskModules'];
                    $grouptaskduedate = date("Y-m-d", strtotime($_POST['groupTaskDueDate']));
                    $grouptaskduetime = date("H:i:s", strtotime($_POST['groupTaskDueTime']));

                    //sanitize
                    $grouptasktitle = mysqli_real_escape_string($conn, $grouptasktitle);
                    $grouptaskmodules = mysqli_real_escape_string($conn,$grouptaskmodules);
                    $grouptasktitle = filter_var($grouptasktitle, FILTER_SANITIZE_STRING);
                    $grouptaskmodules = filter_var($grouptaskmodules, FILTER_SANITIZE_STRING);

                    //first get the people in the group uniquely
                    $sqlgetpeoplefromgroup = "SELECT * FROM messages WHERE GroupID='$fetchgroup' GROUP BY NUSEmail";//or can grp by user id
                    $resultgetpeoplefromgroup = mysqli_query($conn,$sqlgetpeoplefromgroup);

                    while($rowgetpeoplefromgroup = mysqli_fetch_array($resultgetpeoplefromgroup)){
                        $eachuserID = $rowgetpeoplefromgroup['UserID'];

                        //now insert into everyone's task
                        $sqlinsertintotask = "INSERT INTO tasklist (UserID,Tasks, Modules, DueDate, DueTime,Completion)
                        VALUES ('$eachuserID','$grouptasktitle','$grouptaskmodules','$grouptaskduedate','$grouptaskduetime','0')";//0false
                        $resultinsertintotask = mysqli_query($conn,$sqlinsertintotask);
                    }

                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        header("Location: http://localhost/orbital/groupschedulesuccess.php?g=$fetchgroup");
                    }
                    else{
                        header("Location: http://localhost:8080/orbital/groupschedulesuccess.php?g=$fetchgroup");
                    }
                }
                ?>
                </div>

            </div>

            <!--modal for view group task-->
            <!-- The Modal -->
            <div id="myModal4" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                <span class="close4">&times;</span>
                <div>
                <?php
                //first get user id
                $sqlgetuserid2 = "SELECT * FROM users WHERE NUSEmail = '$currentuseremail'";
                $resultgetuserid2= mysqli_query($conn,$sqlgetuserid2);
                $tablenumbering2 = 0;
                while($rowgetuserid2 = mysqli_fetch_array($resultgetuserid2)){
                    $theid2 = $rowgetuserid2['UserID'];

                    //now fetch the task for the user ID
                    $sqlgettask = "SELECT * FROM tasklist WHERE UserID='$theid2' ORDER BY DueDate ASC";//order by date
                    $resultgettask = mysqli_query($conn,$sqlgettask);
                    echo "<div style=\"font-weight:bold;text-decoration:underline;padding:20px;\">Group Task(s)</div>";

                    if(mysqli_num_rows($resultgettask) > 0){//valid, got schedule
                        echo "<table id=\"viewtasktable\">";
                        echo "<tr><td>No.</td><td>Task</td><td>Module</td><td>Due Date</td><td>Due Time</td><td>Action</td></tr>";
                        while($rowgettask = mysqli_fetch_array($resultgettask)){
                            $gettitletask = $rowgettask['Tasks'];

                            //fetch current group name first
                            $sqlfetchcurrentgroup = "SELECT * FROM groups WHERE GroupID='$fetchgroup'";
                            $resultfetchcurrentgroup = mysqli_query($conn,$sqlfetchcurrentgroup);

                            while($rowfetchcurrentgroup = mysqli_fetch_array($resultfetchcurrentgroup)){
                                $currgroupname = $rowfetchcurrentgroup['GroupName'];

                                //compare group name with title (get the title with the group name in it)

                                if (strpos($gettitletask, $currgroupname) !== false){// if exists in that string, then display that schedule
                                    $tablenumbering2 += 1;
                                    $thetasktitle= $rowgettask['Tasks'];
                                    $thetaskmodules = $rowgettask['Modules'];
                                    $duedate = $rowgettask['DueDate'];
                                    $duedateformatted = date('d/m/Y', strtotime($duedate));
                                    $duetime= $rowgettask['DueTime'];
                                    $duetimeformatted = date('H:i', strtotime($duetime));
                                    echo "<tr>";
                                    echo "<td>$tablenumbering2</td>
                                    <td>$thetasktitle</td>
                                    <td>$thetaskmodules</td>
                                    <td>$duedateformatted</td>
                                    <td>$duetimeformatted</td>
                                    <td>
                                    <form method=\"post\"><input type=\"text\" value=\"$thetasktitle\" name=\"doneTaskName\" required hidden>
                                    <button type=\"submit\" name=\"doneTask\" id=\"doneTask\">Done for everyone</button>
                                    </form>
                                    </td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        echo "</table>";
                    }
                    else{
                        echo "<p>No task(s) yet for this group...</p>";
                    }
                }

                //done task button
                if(isset($_POST['doneTask'])){
                    $donetaskname = $_POST['doneTaskName'];
                    //sanitize
                    $donetaskname = mysqli_real_escape_string($conn,$donetaskname);
                    $donetaskname = filter_var($donetaskname, FILTER_SANITIZE_STRING);

                    //get that event from database
                    $sqlgetevent  = "SELECT * FROM tasklist";
                    $resultgetevent = mysqli_query($conn,$sqlgetevent);

                    while($rowgetevent = mysqli_fetch_array($resultgetevent)){
                        $theevent = $rowgetevent['Tasks'];

                        if ($theevent == $donetaskname){//matches db, then delete
                            $gettheid = $rowgetevent['TaskID'];
                            $sqldeleteevent = "DELETE FROM tasklist WHERE TaskID='$gettheid'";
                            $resultdeleteevent = mysqli_query($conn,$sqldeleteevent);

                            //redirect
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                header("Location: http://localhost/orbital/groupschedulesuccess.php?g=$fetchgroup");
                            }
                            else{
                                header("Location: http://localhost:8080/orbital/groupschedulesuccess.php?g=$fetchgroup");
                            }
                        }
                    }
                }
                ?>
                </div>
                </div>

            </div>
        </section>
    </section>
</body>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("addgroupschedule");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    ////////////////=-------------------------modal 2 view schedule
    // Get the modal
    var modal2 = document.getElementById("myModal2");

    // Get the button that opens the modal
    var btn2 = document.getElementById("viewgroupschedule");

    // Get the <span> element that closes the modal
    var span2 = document.getElementsByClassName("close2")[0];

    // When the user clicks the button, open the modal 
    btn2.onclick = function() {
        modal2.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span2.onclick = function() {
        modal2.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }

    ////////////////---------------------------modal 3 add group task
    var modal3 = document.getElementById("myModal3");

    // Get the button that opens the modal
    var btn3 = document.getElementById("addgrouptask");

    // Get the <span> element that closes the modal
    var span3 = document.getElementsByClassName("close3")[0];

    // When the user clicks the button, open the modal 
    btn3.onclick = function() {
        modal3.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span3.onclick = function() {
        modal3.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal3) {
            modal3.style.display = "none";
        }
    }
    /////////////////////////////////////---------------------modal 4 view group task
    var modal4 = document.getElementById("myModal4");

    // Get the button that opens the modal
    var btn4 = document.getElementById("viewgrouptask");

    // Get the <span> element that closes the modal
    var span4 = document.getElementsByClassName("close4")[0];

    // When the user clicks the button, open the modal 
    btn4.onclick = function() {
        modal4.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span4.onclick = function() {
        modal4.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal4) {
            modal4.style.display = "none";
        }
    }
    /////////////////////////////////////////////----------------------------end of modal

    function updateScroll(){
        var element = document.getElementById("thefinalchatbox");
        element.scrollTop = element.scrollHeight;
    }

    setInterval(updateScroll,2500);

</script>
</html>
