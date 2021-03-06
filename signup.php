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
    <link rel="stylesheet" href="css\signup.css">
    <title>StudyLah</title>
</head>
<style>
.linkforgot{
    text-align:center;
    color:lightgray;
    font-style:italic;
    margin-top:10px;
    font-size:12px;
}

.linkforgot:hover{
    cursor:pointer;
    opacity:0.7;
}
</style>
<body id="loadfadein">
    <section>
        <div class="full-page">
        <div class="navbar">
            <nav>
                <ul id='MenuItems'>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
        
        <div class="hero" id='login-form'>
            <div class="form-box">
                <div class="button-box">
                    <div id="btn"></div>
                    <button id="login_btn" type="button" class="toggle-btn" onclick="login()">Log In</button>
                    <button id="register_btn" type="button" class="toggle-btn" onclick="register()">Register</button>
                </div>
                <!--Login-->
                <form id="login" class="input-group" method="post" enctype="multipart/form-data">
                    <input type="email" name="LoginStudentEmail" class="input-field" placeholder="User Email" required>
                    <input type="password" name="LoginUserPassword" class="input-field" minlength="12" placeholder="Enter Password" required>
                    <?php
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a class=\"linkforgot\" href=\"http://localhost/orbital/forgetpassword.php\">Forgot password</a>";
                    }
                    else{
                        echo "<a class=\"linkforgot\" href=\"http://localhost:8080/orbital/forgetpassword.php\">Forgot password</a>";
                    }
                    ?>
                    <button type="submit" class="submit-btn" name="loginbutton">Log In</button>
                    <!--Login PHP-->
                    <?php

                    if(isset($_POST['loginbutton'])){
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

                        $loginpassword=$_POST['LoginUserPassword'];
                        $loginemail=$_POST['LoginStudentEmail'];

                        //sanitize input
                        $loginpassword = mysqli_real_escape_string($conn, $loginpassword);
                        $loginemail = mysqli_real_escape_string($conn,$loginemail);
                        $loginpassword = filter_var($loginpassword, FILTER_SANITIZE_STRING);
                        $loginemail = filter_var($loginemail, FILTER_SANITIZE_STRING);

                        //hash password before checking
                        $loginpasswordhash = hash('sha256', $loginpassword);

                        $sqlfetchlogin="SELECT * FROM users WHERE NUSEmail='$loginemail' AND Password='$loginpasswordhash'";
                        $resultfetchlogin=mysqli_query($conn,$sqlfetchlogin);

                        if(mysqli_num_rows($resultfetchlogin)>0){//if valid login
                            $_SESSION['NUSEmail']=$loginemail;//create session
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                $url="http://localhost/orbital/dashboard.php/";
                                header('Location:' . $url);
                            }
                            else{
                                $url="http://localhost:8080/orbital/dashboard.php/";
                                header('Location:' . $url);
                            }
                        }
                        else{
                            echo "<div style=\"padding:20px;color:red;\">Invalid Email or Password!</div>";
                        }
                    }
                    ?>
                </form>

                <!--Sign Up-->
                <form method="post" enctype="multipart/form-data" onsubmit="return (checkValidation() && checkEmailValidation())" id="register" class="input-group">
                        <input type="text" name="fullname" class="input-field" placeholder="Full Name" required>
                        <input type="email" name="StudentEmail" id="theStudentEmail" class="input-field" placeholder="NUS Email" onkeyup="checkEmail()" required>
                        <div>
                            <div id="alertonmismatchemail" style="padding:10px;color:red;font-size:10px;" hidden>NUS Email needs to be used!</div>
                        </div>
                        <input type="password" class="input-field" name="UserPassword" id="UserPassword" minlength="12" placeholder="Enter Password" required>
                        <input type="password" class="input-field" name="ReUserPassword" id="ReUserPassword" minlength="12" onkeyup="checkPin()" placeholder="Re-Enter/Confirm Password" required>
                        <div>
                            <div id="alertonmismatch" style="padding:10px;color:red;font-size:10px;" hidden>Your pin doesn't match!</div>
                        </div>

                        <select name="Gender" class="input-field" required>
                            <option disabled hidden selected value="Male">Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>

                        <select name="Residency" class="input-field" required>
                            <option disabled hidden selected value="No">Residency Status</option>
                            <option value="No">Does not stay on campus</option>
                            <option value="Yes">Stay on campus</option>
                        </select>

                        <select name="Course" class="input-field" required>
                            <option disabled hidden selected value="Information Security">Course</option>
                            <option value="Data Science and Economics">Data Science and Economics</option>
                            <option value="Food Science and Technology">Food Science and Technology</option>
                            <option value="Humanities Sciences">Humanities Sciences</option>
                            <option value="Pharmaceutical Science">Pharmaceutical Science</option>
                            <option value="Philosophy, Politics, Economics">Philosophy, Politics, Economics</option>
                            <option value="Architecture">Architecture</option>
                            <option value="Industrial Design">Industrial Design</option>
                            <option value="Landscape Architecture">Landscape Architecture</option>
                            <option value="Project & Facilities">Project & Facilities</option>
                            <option value="Real Estate">Real Estate</option>
                            <option value="Biomedical Engineering">Biomedical Engineering</option>
                            <option value="Civil Engineering">Civil Engineering</option>
                            <option value="Chemical Engineering">Chemical Engineering</option>
                            <option value="Engineering Science">Engineering Science</option>
                            <option value="Environmental Engineering">Environmental Engineering</option>
                            <option value="Electrical Engineering">Electrical Engineering</option>
                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                            <option value="Industrial and Systems Engineering">Industrial and Systems Engineering</option>
                            <option value="Material Science Engineering">Material Science Engineering</option>
                            <option value="Business Administration (Accountancy)">Business Administration (Accountancy)</option>
                            <option value="Information Security">Information Security</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Information System">Information System</option>
                            <option value="Business Analytics">Business Analytics</option>
                            <option value="Computer Engineering">Computer Engineering</option>
                            <option value="Dentistry">Dentistry</option>
                            <option value="Undergraduate Law Programme">Undergraduate Law Programme</option>
                            <option value="Medicine">Medicine</option>
                            <option value="Nursing">Nursing</option>
                            <option value="Pharmacy">Pharmacy</option>
                            <option value="Music">Music</option>
                        </select>

                        <select name="YearOfStudy" class="input-field" required>
                            <option disabled hidden selected value="1">Year Of Study</option>
                            <option value="1">Year 1</option>
                            <option value="2">Year 2</option>
                            <option value="3">Year 3</option>
                            <option value="4">Year 4</option>
                            <option value="5">Year 5</option>
                        </select>

                        <label>Current Mods:</label><br>
                            <textarea name="CurrentMod" cols="70" rows="2" id="textareabox" placeholder="e.g. CS2040C, CS2100" class="input-field" required></textarea>
                            <input type="checkbox" class="check-box" required><label id="res">I agree to the <a style="color: #fff" href="javascript:window.open('https://www.websitepolicies.com/policies/view/EZv3Hd3i', 'signup.php', 'width=400,height=400');">terms and conditions.</a></label>
                        <button type="submit" class="submit-btn" name="registerbutton">Register</button>
                        <!--Register PHP-->
                        <?php
                        //phpmailer is a mailing api
                        use PHPMailer\PHPMailer\PHPMailer;
                        use PHPMailer\PHPMailer\Exception;
                        use PHPMailer\PHPMailer\SMTP;

                        require 'PHPMailer/PHPMailer-master/src/Exception.php';
                        require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
                        require 'PHPMailer/PHPMailer-master/src/SMTP.php';

                        if(isset($_POST['registerbutton'])){//once register button is clicked, php is executed
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

                            //sanitize input
                            $signupname= mysqli_real_escape_string($conn,$signupname);
                            $signupgender=mysqli_real_escape_string($conn,$signupgender);
                            $signuppassword=mysqli_real_escape_string($conn,$signuppassword);
                            $signupcourse=mysqli_real_escape_string($conn,$signupcourse);
                            $signupcurrentmod=mysqli_real_escape_string($conn,$signupcurrentmod);
                            $signupyear=mysqli_real_escape_string($conn,$signupyear);
                            $signupresidency=mysqli_real_escape_string($conn,$signupresidency);
                            $signupemail=mysqli_real_escape_string($conn,$signupemail);

                            $signupname = filter_var($signupname, FILTER_SANITIZE_STRING);
                            $signupgender = filter_var($signupgender, FILTER_SANITIZE_STRING);
                            $signuppassword = filter_var($signuppassword, FILTER_SANITIZE_STRING);
                            $signupcourse = filter_var($signupcourse, FILTER_SANITIZE_STRING);
                            $signupcurrentmod = filter_var($signupcurrentmod, FILTER_SANITIZE_STRING);
                            $signupyear = filter_var($signupyear, FILTER_SANITIZE_STRING);
                            $signupresidency = filter_var($signupresidency, FILTER_SANITIZE_STRING);
                            $signupemail = filter_var($signupemail, FILTER_SANITIZE_STRING);

                            //check for duplicate emails in system
                            $sqlcheckduplicate="SELECT * FROM users WHERE NUSEmail='$signupemail'";
                            $resultcheckduplicate=mysqli_query($conn,$sqlcheckduplicate);

                            if(mysqli_num_rows($resultcheckduplicate) > 0){//if got rows, got duplicate.
                                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                    $url="http://localhost/orbital/error.php?error=accountexist";
                                    header('Location:' . $url);
                                }
                                else{
                                    $url="http://localhost:8080/orbital/error.php?error=accountexist";
                                    header('Location:' . $url);
                                }
                            }
                            else{

                                //now check for nus email by using strpos
                                if(strpos($signupemail,"@u.nus.edu") == true){
                                    //hash password
                                    $signuppasswordhash = hash('sha256', $signuppassword);

                                    //insert into sign up
                                    $sqlinsert1="INSERT INTO signup (FullName,Gender,Password,Course,CurrentMod,YearOfStudy,ResidencyStatus,NUSEmail)
                                    VALUES ('$signupname','$signupgender','$signuppasswordhash','$signupcourse','$signupcurrentmod','$signupyear','$signupresidency','$signupemail');";
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
                                    $mail->Password   = 'orbital2021emmus';                               //SMTP password
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                    $mail->Port       = 25;

                                    //Deal with the email
                                    $mail->From = $emailsender; // from
                                    $mail->addReplyTo($emailsender, $sendername); // reply to address/name

                                    $mail->addAddress($signupemail); // to address
                                    $mail->setFrom($emailsender, $sendername);

                                    $mail->Subject = 'StudyLah Account'; // subject
                                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                        $mail->Body = 'Click here to verify your StudyLah account http://localhost/orbital/verify.php?token=' .$token.''; // body
                                    }
                                    else{
                                        $url="http://localhost:8080/orbital/error.php?error=accountexist";
                                        $mail->Body = 'Click here to verify your StudyLah account http://localhost:8080/orbital/verify.php?token=' .$token.''; // body
                                    }
                                    
                                    if(!$mail->send())
                                    { 
                                        echo "<div style=\"color:red;font-size:15px;\">Failed</div>";
                                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                                    }
                                    else{
                                        echo "<script type=\"text/javascript\">location.href = 'thankyou.php';</script>";
                                    }
                                }
                                else{
                                    echo "<div>Error with signing up! Invalid Email.</div>";
                                }
                            }
                        }
                        ?>
                </form>     
        </div>
    </div>
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

            function checkEmail(){
                var checkEmailValid = false;
                theemail = document.getElementById("theStudentEmail").value;
                var indexCheck = theemail.indexOf('@u.nus.edu');//check for nus email
                if(indexCheck > -1){//valid nus email
                    document.getElementById("alertonmismatchemail").setAttribute("hidden", "hidden");
                    document.getElementById("alertonmismatchemail").classList.remove("invalid");
                    checkEmailValid = true;
                }
                else{
                    document.getElementById("alertonmismatchemail").removeAttribute("hidden");
                    document.getElementById("alertonmismatchemail").className = "invalid";
                    checkEmailValid = false;
                }
                return checkEmailValid;
            }           

            function checkEmailValidation(){
                if(!checkEmail()){
                    return false;
                }
                return true;
            }

            var x = document.getElementById('login');
            var y = document.getElementById('register');
            var z = document.getElementById('btn');

            function register(){
                x.style.left = "-400px";
                y.style.left = "85px";
                z.style.left = "110px";
            }

            function login(){
                x.style.left = "85px";
                y.style.left = "500px";
                z.style.left = "0px";
            }
        </script>
        </form>
    </section>
</body>
</html>
