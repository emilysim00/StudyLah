<?php
@ob_start();
session_start();
date_default_timezone_set('Asia/Singapore');
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="icon" href="http://localhost/orbital/images/studylah.png" type="image/icon type">
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
input.invalid{
    background-color:red;
}
</style>
<body>
    <section>
        <h2>Sign Up</h2>
        <script>//Check matching Pin, and validate pin before submission of form
            function checkPin(){
                var valid = true;
                theoriginalpassword=document.getElementById("UserPassword").value;
                repassword=document.getElementById("ReUserPassword").value;
                if(theoriginalpassword != repassword){
                    document.getElementById("alertonmismatch").removeAttribute("hidden");
                    document.getElementById("alertonmismatch").className = "invalid";
                    valid = false;
                }
                else{
                    document.getElementById("alertonmismatch").setAttribute("hidden", "hidden");
                    document.getElementById("alertonmismatch").classList.remove("invalid");
                    valid = true;
                }
                return valid;
            }

            function checkValidation(){
                if(!checkPin()){
                    return false;
                }
                return true;
            }
        </script>
        <form method="post" enctype="multipart/form-data" onsubmit="return checkValidation()">
            <div class="inputspacing">
                <label>Full Name: </label><input type="text" name="fullname" required>
            </div>
            <div class="inputspacing">
                <label>Gender: </label>
                <select name="Gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="inputspacing">
                <label>Course: </label>
                <select name="Course" required>
                    <option value="Information Security">Information Security</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Information System">Information System</option>
                    <option value="Data Analytics">Data Analytics</option>
                    <option value="Business">Business</option>
                </select>
            </div>
            <div class="inputspacing">
                <label>Current Mods:</label><br>
                <textarea name="CurrentMod" cols="70" rows="5" id="textareabox" placeholder="CS2040C, CS2100" required></textarea>
            </div>
            <div class="inputspacing">
                <label>Year of Study: </label>
                <select name="YearOfStudy" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="inputspacing">
                <label>Residency Status: </label>
                <select name="Residency" required>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>
            <div class="inputspacing">
                <label>NUS Email:</label>
                <input type="email" name="StudentEmail" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="UserPassword" id="UserPassword" minlength="12" required>
            </div>
            <div>
                <label>Confirm Password:</label>
                <input type="password" name="ReUserPassword" id="ReUserPassword" minlength="12" onkeyup="checkPin()" required>
            </div>
            <div>
                <div id="alertonmismatch" style="padding:10px;color:red" hidden>Your pin doesn't match!</div>
            </div>
                <!--<input type="text" name="namesender" placeholder="Name" required>
                <input type="email" name="emailsender" placeholder="Email" required>
                <br>
                <button type="submit" name="submitbutton" id="submitbutton">Submit</button>-->
            <br>
            <button type="submit" name="submitbutton">Submit</button>
        </form>
    </section>
</body>
<?php
//phpmailer is a mailing api
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

if(isset($_POST['submitbutton'])){//once button is clicked, php is executed
    //send details to db phpMyAdmin >> config.php (below composer)
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

    //signup details - takes ur input field values
    $signupname= $_POST['fullname'];
    $signupgender=$_POST['Gender'];
    $signuppassword=$_POST['UserPassword'];
    $signupcourse=$_POST['Course'];
    $signupcurrentmod=$_POST['CurrentMod'];
    $signupyear=$_POST['YearOfStudy'];
    $signupresidency=$_POST['Residency'];
    $signupemail=$_POST['StudentEmail'];


    //check for duplicate emails in system
    $sqlcheckduplicate="SELECT * FROM users WHERE NUSEmail='$signupemail'";
    $resultcheckduplicate=mysqli_query($conn,$sqlcheckduplicate);

    if(mysqli_num_rows($resultcheckduplicate) > 0){//if got rows, got duplicate.
        $url="http://localhost/orbital/error.php?error=accountexist";
		header('Location:' . $url);
    }
    else{

        //insert into sign up
        $sqlinsert1="INSERT INTO signup (FullName,Gender,Password,Course,CurrentMod,YearOfStudy,ResidencyStatus,NUSEmail)
        VALUES ('$signupname','$signupgender','$signuppassword','$signupcourse','$signupcurrentmod','$signupyear','$signupresidency','$signupemail');";
        $result1=mysqli_query($conn,$sqlinsert1);

        //insert into pending sign up---------------------------------
        $sqlgetmaxsignupid="SELECT MAX(SignUpID) FROM signup";
        $resultgetmaxsignupid=mysqli_query($conn,$sqlgetmaxsignupid);
        
        //we don't know the sign up ID given, so we get them and insert into pendingsignup because of the SignUpID field
        while($rowgetmaxsignupid=mysqli_fetch_array($resultgetmaxsignupid)){
            $themaxid=$rowgetmaxsignupid['MAX(SignUpID)'];
        }
        
        $token = bin2hex(random_bytes(50));//Generate unique random token of length 100

        $sqlinsert2="INSERT INTO pendingsignup (SignUpID,VerificationToken)
        VALUES ('$themaxid','$token');";
        $result2=mysqli_query($conn,$sqlinsert2);
        
        //phpMailer part------------------------------------------------------
        $sendername='StudyLah';
        $emailsender='StudyLah@nus.com';
        $mail = new PHPMailer(true);

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'chesterworden2@gmail.com';                     //SMTP username
        $mail->Password   = 'orbital2021';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 25;

        //Deal with the email
        $mail->From = $emailsender; // from
        $mail->addReplyTo($emailsender, $sendername); // reply to address/name

        $mail->addAddress($signupemail); // to address
        $mail->setFrom($emailsender, $sendername);

        $mail->Subject = 'StudyLah Account'; // subject
        $mail->Body = 'Click here to verify your StudyLah account http://localhost/orbital/verify.php?token=' .$token.''; // body
        
        if(!$mail->send())
        { 
            echo "<div style=\"color:red;font-size:15px;\">Failed</div>";
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        else{
            echo "<script type=\"text/javascript\">location.href = 'thankyou.php';</script>";
        }
    }
}
?>
</html>