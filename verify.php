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
    <link rel="stylesheet" href="css\verify.css">
    <title>StudyLah</title>
</head>
<style>
</style>
<body>
    <div class="img">
    <div id="background">
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
                $sqlinsertusers="INSERT INTO users (FullName,Gender,Password,Course,CurrentMod,YearOfStudy,ResidencyStatus,NUSEmail, Permission)
                VALUES ('$signupfullname','$signupgender','$signuppassword','$signupcourse','$signupcurrentmod','$signupyearofstudy','$signupresidency','$signupemail','Normal');";
                $resultinsertusers=mysqli_query($conn,$sqlinsertusers);

                //delete from signup and pending signup
                $sqlremovepending="DELETE FROM pendingsignup WHERE SignUpID='$signupID'";
                $resultremovepending=mysqli_query($conn,$sqlremovepending);

                $sqlremovesignup="DELETE FROM signup WHERE SignUpID='$signupID'";
                $resultremovesignup=mysqli_query($conn,$sqlremovesignup);

                //create session to sign up immediately after verification
                $_SESSION['NUSEmail']=$signupemail;//create session

                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                    echo "<h1>Thank You </h1>";
                    echo "<p>You're now a member of our big family. Start your wonderful journey now!</p>";
                    echo "<a href='http://localhost/orbital/dashboard.php/'><button>Start Your Journey</button></a>";
                }
                else{
                    echo "<h1>Thank You </h1>";
                    echo "<p>You're now a member of our big family. Start your wonderful journey now!</p>";
                    echo "<a href='http://localhost:8080/orbital/dashboard.php/'><button>Start My Journey</button></a>";
                }
            }
        }
    }
    else{
        //echo "invalid";
        if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
            $url="http://localhost/orbital/error.php?error=invalidtoken";
		    header('Location:' . $url);
        }
        else{
            $url="http://localhost:8080/orbital/error.php?error=invalidtoken";
		    header('Location:' . $url);
        }
    }
?>
</div>
</div>
</body>
</html>
