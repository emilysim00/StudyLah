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
    <title>StudyLah</title>
</head>
<style>
</style>
<body>
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

    $useremail=$_SESSION['NUSEmail'];
    $sqlgetuser="SELECT * FROM users WHERE NUSEmail='$useremail'";
    $resultgetuser=mysqli_query($conn,$sqlgetuser);

    if(mysqli_num_rows($resultgetuser) > 0){//valid
        while($rowgetuser=mysqli_fetch_array($resultgetuser)){
            $theusername=$rowgetuser['FullName'];
            echo "<h2>Hello $theusername</h2>";
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
    }

    ?>
    </div>
    <!--Logout-->
    <div>
    <form method="post" id="logoutform">
        <button type="submit" name="logout" id="logoutbutton">Logout</button>
    </form>
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
    </div>
</body>
</html>