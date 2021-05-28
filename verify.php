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

    //fetch token
    $fetchtoken=$_GET['token'];//take value from URL
	$sqlselectfrompending="SELECT * FROM pendingsignup WHERE VerificationToken='$fetchtoken'";
	$resultfrompending=mysqli_query($conn,$sqlselectfrompending);

    if(mysqli_num_rows($resultfrompending) > 0){ //is valid PIN, there are rows
        while($rowfetchpending=mysqli_fetch_array($resultfrompending)){
            $thesignupid=$rowfetchpending['SignUpID'];
            //now fetch details from the sign up database and put into users
            $sqlfetchsignup="SELECT * FROM signup WHERE SignUpID='$thesignupid'";
            $resultfetchsignup=mysqli_query($conn,$sqlfetchsignup);

            while($rowfetchsignup=mysqli_fetch_array($resultfetchsignup)){
                $signupID=$rowfetchsignup['SignUpID'];
                $signupfullname=$rowfetchsignup['FullName'];
                $signupgender=$rowfetchsignup['Gender'];
                $signuppassword=$rowfetchsignup['Password'];
                $signupcourse=$rowfetchsignup['Course'];
                $signupcurrentmod=$rowfetchsignup['CurrentMod'];
                $signupyearofstudy=$rowfetchsignup['YearOfStudy'];
                $signupresidency=$rowfetchsignup['ResidencyStatus'];
                $signupemail=$rowfetchsignup['NUSEmail'];
                
                //now insert it into legit users database
                $sqlinsertusers="INSERT INTO users (FullName,Gender,Password,Course,CurrentMod,YearOfStudy,ResidencyStatus,NUSEmail)
                VALUES ('$signupfullname','$signupgender','$signuppassword','$signupcourse','$signupcurrentmod','$signupyearofstudy','$signupresidency','$signupemail');";
                $resultinsertusers=mysqli_query($conn,$sqlinsertusers);

                //delete from signup and pending signup
                $sqlremovepending="DELETE FROM pendingsignup WHERE SignUpID='$signupID'";
                $resultremovepending=mysqli_query($conn,$sqlremovepending);

                $sqlremovesignup="DELETE FROM signup WHERE SignUpID='$signupID'";
                $resultremovesignup=mysqli_query($conn,$sqlremovesignup);

                echo "You are now a legit user. Click <a href='http://localhost/orbital/signup.php'>here</a> to login.";
            }
        }
    }
    else{
        //echo "invalid";
		$url="http://localhost/orbital/error.php?error=invalidtoken";
		header('Location:' . $url);
    }
?>
</body>
</html>