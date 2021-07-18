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
                    <button type="button" class="toggle-btn">Reset Password </button>
                </div>
                <div class="textforgot">Enter your new password and confirm below:</div>
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

                    $thetoken = $_GET['token'];

                    $sqlchecktoken = "SELECT * FROM forgotpassword WHERE VerificationToken = '$thetoken'";
                    $resultchecktoken = mysqli_query($conn,$sqlchecktoken);
                    if(mysqli_num_rows($resultchecktoken) > 0){//valid token
                        while($rowchecktoken = mysqli_fetch_array($resultchecktoken)){
                            $theuseremail = $rowchecktoken['NUSEmail'];
                            echo "<form id=\"login\" class=\"input-group\" method=\"post\">
                            <input type=\"email\" class=\"input-field\" name=\"UserEmail\" id= \"UserEmail\" value=\"$theuseremail\" hidden required>
                            <input type=\"password\" class=\"input-field\" name=\"UserPassword\" id=\"UserPassword\" minlength=\"12\" placeholder=\"Enter Password\" required>
                            <input type=\"password\" class=\"input-field\" name=\"ReUserPassword\" id=\"ReUserPassword\" minlength=\"12\" onkeyup=\"checkPin()\" placeholder=\"Re-Enter/Confirm Password\" required>
                            <div>
                                <div id=\"alertonmismatch\" style=\"padding:10px;color:red\" hidden>Your pin doesn't match!</div>
                            </div>
                            <button type=\"submit\" class=\"submit-btn\" name=\"resetbutton\">Reset</button>";
                        }
                    }
                    else{//invalid token, redirect
                        // Redirect them to error page
                        if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                            $url="http://localhost/orbital/error.php?error=invalidtoken";
                            header('Location:' . $url);
                        }
                        else{
                            $url="http://localhost:8080/orbital/error.php?error=invalidtoken";
                            header('Location:' . $url);
                        }
                    }

                    if(isset($_POST['resetbutton'])){
                        $firstpassword = $_POST['UserPassword'];
                        $secondpassword = $_POST['ReUserPassword'];
                        $nusemail = $_POST['UserEmail'];

                        if($firstpassword != $secondpassword){//password not same 
                            $url="http://localhost/orbital/resetpassword.php?token=$thetoken";
                            header('Location:' . $url);
                        }
                        else{
                            //hash password before placing into db
                            $hashedpassword = md5($secondpassword);
                            //update password
                            $sqlupdatepass = "UPDATE users SET Password = '$hashedpassword' WHERE NUSEmail = '$nusemail'";
                            $resultupdatepass = mysqli_query($conn,$sqlupdatepass);

                            //delete from forogt password
                            $sqldeleteforgot = "DELETE FROM forgotpassword WHERE VerificationToken = '$thetoken' AND NUSEmail = '$nusemail'";
                            $sqldeleteforgot = mysqli_query($conn,$sqldeleteforgot);

                            //redirect
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                $url="http://localhost/orbital/successchange.php";
                                header('Location:' . $url);
                            }
                            else{
                                $url="http://localhost:8080/orbital/successchange.php";
                                header('Location:' . $url);
                            }
                        }
                    }
                    ?>
                </form>   
        </div>
    </div>
    </section>
    <script>
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
</body>
</html>
