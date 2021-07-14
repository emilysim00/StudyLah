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
    <meta http-equiv="refresh" content="20" /><!--reload page every 20 seconds-->
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
                                $sqlupdateseen = "UPDATE messagenotifications SET Status='Seen' WHERE GroupID='$fetchgroup' AND NUSEmail='$currentuseremail'";
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
                                echo "<div><button id=\"addgroupschedule\">+ Add a group schedule</button><button id=\"viewgroupschedule\">View group schedule</button><br><br></div>";
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
                                            $sqlinsertnotificationmessage = "INSERT INTO messagenotifications (GroupID,NUSEmail,NotificationType,Timing,Status,Message)
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

    function updateScroll(){
        var element = document.getElementById("thefinalchatbox");
        element.scrollTop = element.scrollHeight;
    }

    setInterval(updateScroll,2500);

</script>
</html>
