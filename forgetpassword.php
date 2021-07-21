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
body{
    overflow:hidden;
}
#btn{
    top: 0;
    left: 0;
    position: absolute;
    width:180px;
    height:100%;
    background: #F3C693;
    border-radius:30px;
    transition: .5s;
    color: #fff;
    font-weight: bold;
}
.textforgot{
    color:white;
    margin-left:30px;
    font-style:italic;
}

.form-box{
    height:500px;
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
                    <button type="button" class="toggle-btn">Forget Password</button>
                </div>
                <div class="textforgot">A link will be sent to the email you registered with.</div>
                <form id="login" class="input-group" method="post" enctype="multipart/form-data">
                    <input type="email" name="StudentEmail" class="input-field" placeholder="Your email" required>
                    <button type="submit" class="submit-btn" name="loginbutton">Submit</button>
                    <?php
                    //phpmailer is a mailing api
                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\Exception;
                    use PHPMailer\PHPMailer\SMTP;

                    require 'PHPMailer/PHPMailer-master/src/Exception.php';
                    require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
                    require 'PHPMailer/PHPMailer-master/src/SMTP.php';

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

                        $studentemail=$_POST['StudentEmail'];
                        $studentemail = mysqli_real_escape_string($conn,$studentemail); //sanitize
                        $studentemail = filter_var($studentemail, FILTER_SANITIZE_STRING);

                        $sqlcheckemailexist = "SELECT * FROM users WHERE NUSEmail ='$studentemail'";
                        $resultcheckemailexist = mysqli_query($conn,$sqlcheckemailexist);

                        if(mysqli_num_rows($resultcheckemailexist) > 0){//account exist, send email and redirect
                            $token = bin2hex(random_bytes(50));//Generate unique random token of length 100

                            $sqlinsertforgot="INSERT INTO forgotpassword (NUSEmail,VerificationToken)
                            VALUES ('$studentemail','$token');";
                            $resultinsertforgot=mysqli_query($conn,$sqlinsertforgot);
                            
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

                            $mail->addAddress($studentemail); // to address
                            $mail->setFrom($emailsender, $sendername);

                            $mail->Subject = 'StudyLah - Forgot Password'; // subject
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                $mail->Body = 'Click here to reset your StudyLah password http://localhost/orbital/resetpassword.php?token='.$token.''; // body
                            }
                            else{
                                $mail->Body = 'Click here to reset your StudyLah password http://localhost:8080/orbital/resetpassword.php?token='.$token.''; // body
                            }
                            
                            if(!$mail->send())
                            { 
                                echo "<div style=\"color:red;font-size:15px;\">Failed</div>";
                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                            }
                            else{
                                echo "<script type=\"text/javascript\">location.href = 'forgotpasswordthankyou.php';</script>";
                            }
                        }
                        else{
                            echo "<div style=\"color:white;margin-top:20px;\">Ooops... The email is not registered!</div>";
                        }

                    }
                    ?>
                </form>   
        </div>
    </div>
    </section>
</body>
</html>
