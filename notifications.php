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
    .centertable{
        margin:0 auto;
        border-collapse:separate;
        border-spacing:0;
        width:60%;
    }

    tr, td{
        padding:15px;
        text-align:left;
        border-bottom:1px solid #bfbfbf;
        border-collapse:separate;
        border-spacing:0;
    }

    tr:hover{
        opacity:0.7;
        cursor:pointer;
    }

    .notificationcounts{
        border-radius:50%;
        background-color:maroon;
        color:white;
        font-weight:bold;
        font-size:12px;
        padding:5px 10px;
    }

    .sectiontitle{
        font-size:18px;
        text-decoration:underline;
        padding:20px;
    }

    .timingstyle{
        color:gray;
        font-size:12px;
    }

    .unread{
        background-color:#ffd1d1;
    }

    .deletenotifications{
        border:none;
        background-color:white;
        z-index:100;
    }
    .deletenotifications:hover{
        cursor:pointer;
        opacity:0.7;
    }
    </style>
<body style="font-family: 'Inter', sans-serif;">
    <!--navbar-->
    <?php include('header.php');?>
    <!--message section-->
    <section style="background-color:#424240;">
        <section id="messagesection">
            <div>
                <div class="bigtext">Notifications </div>
                <div style="margin-bottom:30px;"></div>
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

                //Messages
                echo "<div class=\"sectiontitle\">Messages</div>";

                $sqlfetchmessages = "SELECT * FROM notifications WHERE NUSEmail = '$useremail' AND (NotificationType='Message' OR NotificationType='NewAdded') ORDER BY NotificationID DESC";
                $resultfetchmessages = mysqli_query($conn,$sqlfetchmessages);

                if(mysqli_num_rows($resultfetchmessages) > 0){//got messages notifications
                    while($rowfetchmessages = mysqli_fetch_array($resultfetchmessages)){
                        $messagestatus = $rowfetchmessages['Status'];
                        $groupid=$rowfetchmessages['GroupID'];
                        $notificationid = $rowfetchmessages['NotificationID'];

                        echo "<table class=\"centertable\">";
                        if($messagestatus == 'Unseen'){//unseen, colour cell
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                echo "<tr class=\"unread\" onclick=\"window.location.href='http://localhost/orbital/seemessage.php?group=$groupid'\">";
                            }
                            else{
                                echo "<tr class=\"unread\" onclick=\"window.location.href='http://localhost:8080/orbital/seemessage.php?group=$groupid'\">";
                            } 
                        }
                        else{
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                echo "<tr onclick=\"window.location.href='http://localhost/orbital/seemessage.php?group=$groupid'\">";
                            }
                            else{
                                echo "<tr onclick=\"window.location.href='http://localhost:8080/orbital/seemessage.php?group=$groupid'\">";
                            } 
                        }
                        echo "<td>".$rowfetchmessages['Message']."<br><br><span class=\"timingstyle\">".$rowfetchmessages['Timing']."</span></td>";
                        echo "<td><form method=\"post\">
                        <input type=\"number\" name=\"themessagenotificationid\" value=\"$notificationid\" hidden required>
                        <button type=\"submit\" class=\"deletenotifications\" name=\"deletemessagenotifications\">
                        <img src=\"img/delete.png\" width=\"17px\" height=\"17px\" alt=\"deletenoti\">
                        </button>
                        </form></td>";
                        echo "</tr>";
                        echo "</table>";
                    }
                }
                else{
                    echo "No message notifications...";
                }

                if(isset($_POST['deletemessagenotifications'])){
                    $thedeletenotiID=$_POST['themessagenotificationid'];

                    $sqldeletemessagenoti = "DELETE FROM notifications WHERE NotificationID='$thedeletenotiID'";
                    $resultdeletemessagenoti=mysqli_query($conn,$sqldeletemessagenoti);

                    // Redirect
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        header("Location: http://localhost/orbital/notifications.php");
                    }
                    else{
                        header("Location: http://localhost:8080/orbital/notifications.php");
                    } 
                }

                echo "<br><br>";
                echo "<hr>";
                //Forum
                echo "<div class=\"sectiontitle\">Forum</div>";

                $sqlfetchforum = "SELECT * FROM notifications WHERE NUSEmail = '$useremail' AND NotificationType='Forum' ORDER BY NotificationID DESC";
                $resultfetchforum = mysqli_query($conn,$sqlfetchforum);

                if(mysqli_num_rows($resultfetchforum) > 0){//got forum notifications
                    while($rowfetchforum = mysqli_fetch_array($resultfetchforum)){
                        $forumstatus = $rowfetchforum['Status'];
                        $forumgroupid=$rowfetchforum['GroupID'];
                        $forumnotificationid = $rowfetchforum['NotificationID'];

                        echo "<table class=\"centertable\">";
                        if($forumstatus == 'Unseen'){//unseen, colour cell
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                echo "<tr class=\"unread\" onclick=\"window.location.href='http://localhost/orbital/viewforum.php?forum=$forumgroupid'\">";
                            }
                            else{
                                echo "<tr class=\"unread\" onclick=\"window.location.href='http://localhost:8080/orbital/viewforum.php?forum=$forumgroupid'\">";
                            } 
                        }
                        else{
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                echo "<tr onclick=\"window.location.href='http://localhost/orbital/viewforum.php?forum=$forumgroupid'\">";
                            }
                            else{
                                echo "<tr onclick=\"window.location.href='http://localhost:8080/orbital/viewforum.php?forum=$forumgroupid'\">";
                            } 
                        }
                        echo "<td>".$rowfetchforum['Message']."<br><br><span class=\"timingstyle\">".$rowfetchforum['Timing']."</span></td>";
                        echo "<td><form method=\"post\">
                        <input type=\"number\" name=\"theforumnotificationid\" value=\"$forumnotificationid\" hidden required>
                        <button type=\"submit\" class=\"deletenotifications\" name=\"deleteforumnotifications\">
                        <img src=\"img/delete.png\" width=\"17px\" height=\"17px\" alt=\"deletenoti\">
                        </button>
                        </form></td>";
                        echo "</tr>";
                        echo "</table>";
                    }
                }
                else{
                    echo "No forum notifications...";
                }

                if(isset($_POST['deleteforumnotifications'])){
                    $thedeletenotiID=$_POST['theforumnotificationid'];

                    $sqldeleteforumnoti = "DELETE FROM notifications WHERE NotificationID='$thedeletenotiID'";
                    $resultdeleteforumnoti=mysqli_query($conn,$sqldeleteforumnoti);

                    // Redirect
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        header("Location: http://localhost/orbital/notifications.php");
                    }
                    else{
                        header("Location: http://localhost:8080/orbital/notifications.php");
                    } 
                }
                ?>
            </div>
        </section>
    </section>
</body>
</html>