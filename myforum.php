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
    #newforum:hover{
        opacity:0.7;
        cursor:pointer;
    }
    #theforums{
        margin:0 auto;
        border-collapse:separate;
        border-spacing:0;
        width:70%;
        vertical-align:top;
    }

    tr, td{
        padding:20px;
        text-align:left;
        border-bottom:1px solid #bfbfbf;
        border-collapse:separate;
        border-spacing:0;
        vertical-align:top;
    }

    .profalign{
        text-align:right;

    }

    .groupprofilepic{
        border-radius:50%;
    }

    .theforumtitle{
        font-weight:bold;
        font-size:20px;
    }

    .eachforumrow:hover{
        opacity:0.7;
        cursor:pointer;
    }
    
    .forumbuttons{
        border:none;
        padding:5px 7px;
        margin-top:20px;
    }

    .left{
        border-top-left-radius:10px;
        border-bottom-left-radius:10px;
        color:#5d4954;
        background-color:lightgray;
    }

    .right{
        border-top-right-radius:10px;
        border-bottom-right-radius:10px;
        background-color:#5d4954;
        color:lightgray;
    }

    .forumbuttons:hover{
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
                <div class="bigtext">My Forum Posts</div>
                <div>
                <?php
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/createforum.php\"><img src=\"img/pen.png\" width=\"20px\" height=\"20px\" alt=\"new forum\" id=\"newforum\"></a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/createforum.php\"><img src=\"img/pen.png\" width=\"20px\" height=\"20px\" alt=\"new forum\" id=\"newforum\"></a>";
                    } 
                ?>
                </div>
                <div>
                    <?php
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<button class=\"forumbuttons left\" type=\"button\" onclick=\"window.location.href='http://localhost/orbital/forum.php'\">All Forum</button>";
                        echo "<button class=\"forumbuttons right\" type=\"button\" onclick=\"window.location.href='http://localhost/orbital/myforum.php'\">My Forum</button>";
                    }
                    else{
                        echo "<button class=\"forumbuttons left\" type=\"button\" onclick=\"window.location.href='http://localhost:8080/orbital/forum.php'\">All Forum</button>";
                        echo "<button class=\"forumbuttons right\" type=\"button\" onclick=\"window.location.href='http://localhost:8080/orbital/myforum.php'\">My Forum</button>";
                    } 
                    ?>
                </div>
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

                //fetch user id 
                $sqlgetcurruserid = "SELECT * FROM users WHERE NUSEmail = '$useremail'";
                $resultgetcurruserid = mysqli_query($conn,$sqlgetcurruserid);

                while($rowgetcurruserid = mysqli_fetch_array($resultgetcurruserid)){
                    $thecurruserid = $rowgetcurruserid['UserID'];
                    echo "<div>";
                    $sqlgetforums = "SELECT * FROM forum WHERE ReplyToID='0' AND UserID='$thecurruserid' ORDER BY ForumID DESC";//reply id 0 main
                    $resultgetforums = mysqli_query($conn, $sqlgetforums);
                }
                //display forum
               
                echo "<table id=\"theforums\">";

                if(mysqli_num_rows($resultgetforums) > 0){//got existing forum
                    while($rowgetforums = mysqli_fetch_array($resultgetforums)){
                        $forumid = $rowgetforums['ForumID'];
                        //onclick redirect
                        if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                            echo "<tr class=\"eachforumrow\" onclick=\"window.location.href='http://localhost/orbital/viewforum.php?forum=$forumid'\">";
                        }
                        else{
                            echo "<tr class=\"eachforumrow\" onclick=\"window.location.href='http://localhost:8080/orbital/viewforum.php?forum=$forumid'\">";
                        }
                        //get user first
                        $forumuserid = $rowgetforums['UserID'];

                        $sqlgetuser = "SELECT * FROM users WHERE UserID= '$forumuserid'";
                        $resultgetuser = mysqli_query($conn,$sqlgetuser);

                        while($rowgetuser = mysqli_fetch_array($resultgetuser)){
                            //get profile pic
                            $profilepic=$rowgetuser['ProfilePic'];
                            if($profilepic == NULL || $profilepic == ""){
                                echo "<td class=\"profalign\"><img src=\"img/user.png\" width=\"40px\" height=\"40px\" alt=\"profilepic\" class=\"groupprofilepic\"></td>";
                            }
                            else{
                                echo "<td class=\"profalign\"><img src=\"userprofilepic/$profilepic\" width=\"40px\" height=\"40px\" alt=\"profilepic\" class=\"groupprofilepic\"></td>";
                            }

                            echo "<td><span style=\"font-size:15px;color:gray;\">".$rowgetuser['FullName']."&nbsp&nbsp ".$rowgetforums['Timing']."</span>";
                        }
                        
                        echo "<br><br><span class=\"theforumtitle\">".$rowgetforums['Title']."</span></td>";
                        echo "</tr>";
                    }
                }
                else{
                    echo "<div>No forums yet...</div>";
                }
                echo "</table>";
                echo "</div>";
                ?>
            </div>
        </section>
    </section>
</body>
</html>
