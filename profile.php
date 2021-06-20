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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css\navbar.css">
    <link rel="stylesheet" href="css\profile.css">
    <title>StudyLah</title>
</head>
<body style="font-family: 'Inter', sans-serif;">
    <!--navbar-->
    <?php include('header.php');?>
    <!--profile section-->
    <section style="background-color:#424240;">
        <section id="profilesection">
            <div>
                <div class="bigtext">My Profile <span id="editprofile">
                    <?php
                    //edit profile button
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<button onclick=\"location.href='http://localhost/orbital/editprofile.php'\">Edit profile</button>";
                    }
                    else{
                        echo "<button onclick=\"location.href='http://localhost:8080/orbital/editprofile.php'\">Edit profile</button>";
                    } 
                    ?>
                    </span>
                </div>
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
                        //display profile picture
                        $profilepic=$rowgetuser['ProfilePic'];
                        if($profilepic=="" || $profilepic==NULL){
                            echo "<div><img src=\"img/user.png\" id=\"profilepic\" alt=\"profilepic\" width=\"250px\" height=\"250px\"></div>";
                        }
                        else{
                            echo "<div><img src=\"userprofilepic/$profilepic\" id=\"profilepic\" alt=\"profilepic\" width=\"250px\" height=\"250px\"></div>";
                        }

                        //display name
                        $fullname= $rowgetuser['FullName'];
                        echo "<div style=\"font-size:25px;\">$fullname</div>";
                        
                        //display course and year
                        $course= $rowgetuser['Course'];
                        $yearofstudy = $rowgetuser['YearOfStudy'];
                        echo "<div style=\"color:gray;\">$course Year $yearofstudy</div>";

                        //display bio
                        $bio = $rowgetuser['Bio'];
                        if($bio != "" || $bio!=NULL){
                            echo "<div id=\"profilebio\"> \" $bio \"</div>";
                        }

                        echo "<hr class=\"hrstyle\">";

                        //Other details -- table 
                        $residencystat= $rowgetuser['ResidencyStatus'];
                        $currentmod= $rowgetuser['CurrentMod'];
                        $pastmod= $rowgetuser['PastMod'];
                        $cca= $rowgetuser['CCA'];

                        echo "<div style=\"font-size:20px;text-decoration:underline;\">Other Details</div>";
                        //residency
                        echo "<table class=\"centertable\">
                        <tr><td>Residency:</td>";
                        
                        if($residencystat=="Yes"){
                            echo "<td class=\"tdsecond\">Stays in campus</td>";
                        }   
                        else{
                            echo "<td class=\"tdsecond\">Does not stay in campus</td>";
                        }
                        echo "</tr>";
                    
                    //curent mods
                        echo "<tr>
                            <td>Current Mods:</td><td class=\"tdsecond\">";
                        if ($currentmod == "" || $currentmod == NULL){
                            echo "None";
                        }
                        else{
                            $currentmodexplode=preg_split('/[\ \n\,]+/', $currentmod);//split string by regular expressions comma, space e.g and put into array
                            for($eachmod = 0;$eachmod < count($currentmodexplode); $eachmod++){
                                $getmods=$currentmodexplode[$eachmod];
                                echo "$getmods<br>";
                            }
                        }
                        echo "</td></tr>";

                        //past mods
                        echo "<tr>
                            <td>Past Mods:</td><td class=\"tdsecond\">";
                        if ($pastmod == "" || $pastmod == NULL){
                            echo "None";
                        }
                        else{
                            $pastmodexplode=preg_split('/[\ \n\,]+/', $pastmod);//split string by regular expressions comma, space e.g and put into array
                            for($eachpastmod = 0;$eachpastmod < count($pastmodexplode); $eachpastmod++){
                                $getpastmods=$pastmodexplode[$eachpastmod];
                                echo "$getpastmods<br>";
                            }
                        }
                        echo "</td></tr>";

                        //CCA or Clubs
                        echo "<tr>
                            <td>CCAs/Clubs</td><td class=\"tdsecond\">";
                        if ($cca == "" || $cca == NULL){
                            echo "None";
                        }
                        else{
                            $ccaexplode=explode(",", $cca);//split by comma
                            for($eachcca = 0;$eachcca < count($ccaexplode); $eachcca++){
                                $getcca=$ccaexplode[$eachcca];
                                echo "$getcca<br>";
                            }
                        }
                        echo "</td></tr>";
                        echo "</table>";
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
        </section>
    </section>
</body>
</html>
