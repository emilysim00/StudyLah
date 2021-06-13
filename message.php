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
    <link rel="stylesheet" href="css\header.css">
    <link rel="stylesheet" href="css\message.css">
    <title>StudyLah</title>
</head>
<style>
    #newmessage:hover{
        opacity:0.7;
        cursor:pointer;
    }
    .centertable{
        margin:0 auto;
        border-collapse:separate;
        border-spacing:0;
        width:70%;
    }

    tr, td{
        padding:15px;
        text-align:left;
        border-bottom:1px solid #bfbfbf;
        border-collapse:separate;
        border-spacing:0;
    }
    .groupprofilepic{
        border-radius:50%;
    }

    .groupnamefont{
        font-size:20px;
    }

    .thefinalmessage{
        color:#adacac;
    }

    .eachchatrow:hover{
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
    </style>
<body>
    <!--navbar-->
    <?php include('header.php');?>
    <!--message section-->
    <section style="background-color:#424240;">
        <section id="messagesection">
            <div>
                <div class="bigtext">Messages </div>
                <div>
                    <?php

                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/createmessage.php\"><img src=\"img/new-email.png\" width=\"50px\" height=\"50px\" alt=\"new message\" id=\"newmessage\"></a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/createmessage.php\"><img src=\"img/new-email.png\" width=\"50px\" height=\"50px\" alt=\"new message\" id=\"newmessage\"></a>";
                    } 
                    ?>
                </div>
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

                $sqlgetgroups = "SELECT * FROM messages WHERE NUSEmail='$useremail' GROUP BY GroupID";//group by is no duplicate
                $resultgetgroups = mysqli_query($conn,$sqlgetgroups);

                echo "<table class=\"centertable\">";
                if(mysqli_num_rows($resultgetgroups) > 0){//got existing messages, groups etc
                    while($rowgetgroups=mysqli_fetch_array($resultgetgroups)){
                        //display group details etc
                        $mygroups = $rowgetgroups['GroupID'];

                        $sqlgroupdetails = "SELECT * FROM groups WHERE GroupID='$mygroups'";
                        $resultgroupdetails = mysqli_query($conn,$sqlgroupdetails);

                        while($rowgroupdetails=mysqli_fetch_array($resultgroupdetails)){
                            $groupid=$rowgroupdetails['GroupID'];
                            $grouppic = $rowgroupdetails['GroupPic'];
                            $groupname = $rowgroupdetails['GroupName'];

                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                echo "<tr class=\"eachchatrow\" onclick=\"window.location.href='http://localhost/orbital/seemessage.php?group=$mygroups'\">";
                            }
                            else{
                                echo "<tr class=\"eachchatrow\" onclick=\"window.location.href='http://localhost:8080/orbital/seemessage.php?group=$mygroups'\">";
                            }
                            if ($grouppic == "" || $grouppic == NULL) {
                                echo "<td><img src=\"img/user.png\" width=\"80px\" height=\"80px\" alt=\"groupprofile\" class=\"groupprofilepic\"></td>";
                            }
                            else{
                                echo "<td><img src=\"grouppic/$grouppic\" width=\"80px\" height=\"80px\" alt=\"groupprofile\" class=\"groupprofilepic\"></td>";
                            }

                            echo "<td><span class=\"groupnamefont\">$groupname</span><br><br>";

                            //display last message
                            $sqlgetlastmessage= "SELECT MAX(MessageID) FROM messages WHERE GroupID='$mygroups'";
                            $resultgetlastmessage = mysqli_query($conn,$sqlgetlastmessage);

                            echo "<span class=\"thefinalmessage\">";
                            //last msg
                            if(mysqli_num_rows($resultgetlastmessage) > 0){//got last messages
                                while($rowgetlastmessage=mysqli_fetch_array($resultgetlastmessage)){
                                    $thelastmessageid = $rowgetlastmessage['MAX(MessageID)'];

                                    $sqlfetchfinalmessage = "SELECT * FROM messages WHERE MessageID='$thelastmessageid'";
                                    $resultfetchfinalmessage = mysqli_query($conn,$sqlfetchfinalmessage);

                                    while($rowfetchfinalmessage = mysqli_fetch_array($resultfetchfinalmessage)){
                                        $thereallastmessage = $rowfetchfinalmessage['Message'];
                                        $thelastmessagefullname=$rowfetchfinalmessage['FullName'];
                                        $thelastmessagetiming = $rowfetchfinalmessage['Timing'];
                                        echo "$thelastmessagefullname";
                                        echo ": ";
                                        echo "$thereallastmessage";
                                        echo "<br><br>";
                                        echo "<span style=\"font-size:12px;\">$thelastmessagetiming</span>";
                                    }
                                }
                            }
                            echo "</span></td>";

                            //display how many notifications for that user - unseen only
                            $sqlgetnotifications = "SELECT * FROM messagenotifications WHERE GroupID='$groupid' AND NUSEmail='$useremail' AND Status='Unseen'";
                            $resultgetnotifications = mysqli_query($conn,$sqlgetnotifications);
                            $notificationcount = 0;

                            if(mysqli_num_rows($resultgetnotifications) > 0){//got notifications
                                while($rowgetnotifications = mysqli_fetch_array($resultgetnotifications)){
                                    $notificationcount += 1;
                                }
                                echo "<td><span class=\"notificationcounts\">$notificationcount</span></td>";
                            }
                            else{
                                echo "<td></td>";
                            }  
                            echo "</tr>";
                            
                        }
                    }
                }
                else{
                    echo "<div>You have no chats/messages!</div>";
                }
                echo "</table>";

                /*$sqlgetuser="SELECT * FROM users WHERE NUSEmail='$useremail'";
                $resultgetuser=mysqli_query($conn,$sqlgetuser);

                if(mysqli_num_rows($resultgetuser) > 0){//valid
                    while($rowgetuser=mysqli_fetch_array($resultgetuser)){
                        //display profile picture
                       
                    }
                }
                else{
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        $url="http://localhost/orbital/signup.php";
                        header('Location:' . $url);
                    }
                    else{
                        $url="http://localhost:8080/orbital/signup.php";
                        header('Location:' . $url);
                    } 
                }*/

                ?>
            </div>
        </section>
    </section>
</body>
</html>