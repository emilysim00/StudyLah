<?php
@ob_start();
session_start();
date_default_timezone_set('Asia/Singapore');
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="icon" href="http://localhost/orbital/img/studylah.png" type="image/icon type">
    <!--<link rel="icon" href="http://glyphconcepts.com/wp-content/uploads/2020/05/Symbol-Black-Circle.png" type="image/icon type">
	<link href="https://fonts.googleapis.com/css2?family=Lora&family=Montserrat:wght@300&family=Spectral&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />-->
    <title>StudyLah</title>
</head>
<style>
</style>
<body>
    <div>
    <?php
    $fetcherrortype=$_GET['error'];
    if($fetcherrortype=='invalidtoken'){
        echo "<h2>INVALID TOKEN!!!!</h2>";
    }
    else if($fetcherrortype=='accountexist'){
        echo "<h2>Account already exists!!!!</h2>";
    }
    else{//general error
        echo "oops, there seems to be an error!";
        echo "<a href='http://localhost/orbital/signup.php'>here</a>";
    }
    ?>
    </div>
</body>
</html>