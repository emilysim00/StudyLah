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
    .backbutton{
        text-align:left;
        margin-left:30px;
    }
    .backbutton:hover{
        cursor:pointer;
        opacity:0.7;
    }

    #submitforumbutton{
        border-radius:5px;
        background-color:black;
        color:white;
        border:none;
        padding:5px 7px;
        margin-top:20px;
        margin-bottom:50px;
    }

    #submitforumbutton:hover{
        opacity:0.7;
        cursor:pointer;
    }
    </style>
<body style="font-family: 'Inter', sans-serif;">
    <!--navbar-->
    <?php include('header.php');?>
    <!--message section-->
    <section style="background-color:#424240;">
        <section id="messagesection">
            <div>
                <div>
                <?php
                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                    echo "<div class=\"backbutton\" onclick=\"window.location.href='http://localhost/orbital/forum.php'\"><img src=\"img/back.png\" width=\"15px\" height=\"15px\" class=\"backpic\">Back</div>";//back button
                }
                else{
                    echo "<div class=\"backbutton\" onclick=\"window.location.href='http://localhost:8080/orbital/forum.php'\"><img src=\"img/back.png\" width=\"15px\" height=\"15px\" class=\"backpic\">Back</div>";//back button
                }
                ?>
                </div>
                <div class="bigtext">Create Forum </div>
                <div style="margin-bottom:30px;"></div>
                <div><!--forum-->
                <form method="post" enctype="multipart/form-data">
                    <div>Title:</div>
                    <textarea cols="20" rows="5" placeholder="Type a title" name="forumTitle" required></textarea>
                    <div>Text:</div>
                    <textarea cols="70" rows="5" placeholder="Type your text" name="forumText" required></textarea>
                    <div><button type="submit" name="submitForum" id="submitforumbutton">Post</button></div>
                </form>
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
                $timestamp=date('Y-m-d H:i:s');//timestamp format

                if(isset($_POST['submitForum'])){

                    $forumtitle = $_POST['forumTitle'];
                    $forumText = $_POST['forumText'];
                    //first get current user
                    $sqlgetcurrentuser = "SELECT * FROM users WHERE NUSEmail = '$useremail'";
                    $resultgetcurrentuser = mysqli_query($conn, $sqlgetcurrentuser);

                    while($rowgetcurrentuser=mysqli_fetch_array($resultgetcurrentuser)){
                        $curruserid = $rowgetcurrentuser['UserID'];
                        $currname = $rowgetcurrentuser['FullName'];

                        //insert into forum
                        $sqlinsertforum = "INSERT INTO forum (UserID, NUSEmail, FullName, Title, Message, Timing, ReplyToID)
                        VALUES ('$curruserid', '$useremail', '$currname', '$forumtitle','$forumText','$timestamp','0')";//default main 0
                        $resultinsertforum = mysqli_query($conn, $sqlinsertforum);

                        //redirect
                        if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                            $url="http://localhost/orbital/forum.php";
                            header('Location:' . $url);
                        }
                        else{
                            $url="http://localhost:8080/orbital/forum.php";
                            header('Location:' . $url);
                        }

                    }
                }

                ?>
                </div>
            </div>
        </section>
    </section>
</body>
</html>
