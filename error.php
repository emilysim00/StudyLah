<?php
@ob_start();
session_start();
date_default_timezone_set('Asia/Singapore');
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="icon" href="img\studylah_logo.jpg" type="image/jpg">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="css\error.css">
    <title>StudyLah</title>
</head>
<body>
    <div class="bg">
        <div class="centered">
            <?php
            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                echo "<div onclick=\"window.location.href='http://localhost/orbital/signup.php'\" id=\"closebutton\" class=\"close\">&times;</div>";
            }
            else{
                echo "<div onclick=\"window.location.href='http://localhost:8080/orbital/signup.php'\" id=\"closebutton\" class=\"close\">&times;</div>";
            }
            ?>
            <div class="inline">
                <img src="img/close.png" width="50px" height="50px" alt="error img">
            </div>
            <div class="inline">
                <div>
                    <h2>Error!</h2>
                </div>
                <?php
                $fetcherrortype=$_GET['error'];
                if($fetcherrortype=='invalidtoken'){
                    echo "<div>Your token is invalid :(</div>";
                }
                else if($fetcherrortype=='accountexist'){
                    echo "<div>Account already exists!</div>";
                }
                else if($fetcherrortype == 'unauthorizedgroup'){
                    echo "<div>You are unauthorized to view this group message!</div>";
                }
                else if($fetcherrortype == 'usernotfound'){
                    echo "<div>User not found :(!</div>";
                }
                else{//general error
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<div>Oops, there seems to be an error! <br>Go back <a href='http://localhost/orbital/signup.php'>here.</a></div>";
                    }
                    else{
                        echo "<div>Oops, there seems to be an error! <br>Go back <a href='http://localhost:8080/orbital/signup.php'>here.</a></div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
