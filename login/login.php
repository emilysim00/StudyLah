<?php
@ob_start();
session_start();
date_default_timezone_set('Asia/Singapore');
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" /><link rel="icon" href="img\studylah_logo.jpg" type="image/jpg">
    <!--<link rel="icon" href="http://glyphconcepts.com/wp-content/uploads/2020/05/Symbol-Black-Circle.png" type="image/icon type">
	<link href="https://fonts.googleapis.com/css2?family=Lora&family=Montserrat:wght@300&family=Spectral&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />-->
    <title>StudyLah</title>
</head>
<style>
.inputspacing {
    padding:10px;

}
</style>
<body>
    <section>
        
        <h2>Login</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="inputspacing">
                <label>Email:</label>
                <input type="email" name="StudentEmail" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="UserPassword" id="UserPassword" minlength="12" required>
            </div>
            <br>
            <button type="submit" name="loginbutton">Login</button>
        </form>
    </section>
</body>
<?php

if(isset($_POST['loginbutton'])){
    //send details to db phpMyAdmin >> config.php (below composer)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname= "studylah_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $loginpassword=$_POST['UserPassword'];
    $loginemail=$_POST['StudentEmail'];

    $sqlfetchlogin="SELECT * FROM users WHERE NUSEmail='$loginemail' AND Password='$loginpassword'";
    $resultfetchlogin=mysqli_query($conn,$sqlfetchlogin);

    if(mysqli_num_rows($resultfetchlogin)>0){//if valid login
        $_SESSION['NUSEmail']=$loginemail;//create session
        $url="http://localhost:8080/login/dashboard.php/";
		header('Location:' . $url);
    }
    else{
        echo "<div style=\"padding:20px;color:red;\">Invalid Email or Password!</div>";
    }
}
?>
</html>