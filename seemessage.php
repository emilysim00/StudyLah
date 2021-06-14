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
    <title>StudyLah</title>
</head>
<style>
    #newmessage:hover{
        opacity:0.7;
        cursor:pointer;
    }

    #groupdetails{
        margin-top:50px;
    }

    #grouppicture{
        border-radius:50%;
    }

    #groupdetailsname{
        padding:10px;

    }

    .currentusermessage{
        display:block;
        float:right;
        width:200px;
        padding:10px;
        background-color:#92b4fc;
        text-align:left;
        border-radius:5px;
    }

    .otherusermessage{
        display:block;
        width:200px;
        padding:10px;
        background-color:white;
        text-align:left;
        border: 1px solid gray;
        margin-top:20px;
        border-radius:5px;
    }

    #chatbox{
        clear:left;
        clear:right;
        margin-top:10px;
        padding:20px;
    }

    .clearfloats{
        clear:left;
        clear:right;
        padding:15px;
    }

    .thefinalchatbox{
        width:75%;
        display:block;
        margin:0 auto;
        max-height:300px;
        overflow:scroll;
        overflow-x:hidden;
    }

    .metext{
        margin-bottom:5px;
        font-size:10px;
        color:#21489c;
    }

    .otherusertext{
        margin-bottom:5px;
        font-size:10px;
        color:#e039e3;
    }

    .timestamp{
        font-size:10px;
        text-align:left;
        color:gray;
    }

    #mychatbutton{
        background-color:black;
        color:white;
        padding:5px;
        border-radius:10px;
        border:none;
    }

    #mychatbutton:hover{
        opacity:0.7;
        cursor:pointer;
    }

    .backbutton{
        text-align:left;
        padding:5px 20px;
        font-size:15px;
    }

    .backbutton:hover{
        cursor:pointer;
        opacity:0.7;
    }

    .backpic{
        vertical-align:middle;
        margin-right:5px;
    }
    </style>
<body>
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
                                echo "<hr>";
                                echo "</div>";
                               
                                //now display the messages chat
                                $sqlgetmessages = "SELECT * FROM messages WHERE GroupID='$fetchgroup' ORDER BY MessageID ASC";
                                $resultgetmessages= mysqli_query($conn,$sqlgetmessages);
                                echo "<div class =\"thefinalchatbox\">";
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
                                            echo "<div class=\"otherusermessage\">";
                                            echo "<div class=\"otherusertext\">".$rowgetmessages['FullName']."</div>";
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
        </section>
    </section>
</body>
</html>