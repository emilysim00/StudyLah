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
    <link rel="stylesheet" href="css\editprofile.css">
    <title>StudyLah</title>
</head>
<body onload="populateSelectFields();" style="font-family: 'Inter', sans-serif;">
    <!--navbar-->
    <?php include('header.php');?>
    <!--profile section-->
    <section style="background-color:#424240;">
        <section id="profilesection">
            <form method="post" enctype="multipart/form-data">
            <div>
                <div class="bigtext">Edit Profile</div>
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
                            echo "<div><img src=\"img/user.png\" id=\"profilepic\" alt=\"profilepic\" width=\"250px\" height=\"250px\" onclick=\"clickonFile()\">
                            <input type=\"file\" id=\"newProfilePicture\" name=\"newProfilePicture\" style=\"display: none;\" onchange=\"loadFile(event)\"/>
                            <div><img id=\"output\" width=\"250px\" height=\"250px\" style=\"border-radius:50%;\" hidden/></div>
                            </div>";
                            //output is the output pic on upload
                        }
                        else{
                            echo "<div><img src=\"userprofilepic/$profilepic\" id=\"profilepic\" alt=\"profilepic\" width=\"250px\" height=\"250px\" onclick=\"clickonFile()\">
                            <input type=\"file\" id=\"newProfilePicture\" name=\"newProfilePicture\" style=\"display: none;\" onchange=\"loadFile(event)\"/>
                            <div><img id=\"output\" width=\"250px\" height=\"250px\" style=\"border-radius:50%;\" hidden/></div>
                            </div>";
                        }
                        echo "<input type=\"text\" value=\"$profilepic\" name=\"userLastProfilePic\" hidden style=\"display:none\">"; //last profilepicture

                        //table first section

                        //edit name
                        $fullname= $rowgetuser['FullName'];
                        echo "<table class=\"centertable\">";
                        echo "<tr><td>Name:</td>
                        <td><input type=\"text\" value=\"$fullname\" name=\"editFullName\" required></td>";
                        echo "</tr>";
                        
                        //edit course
                        $course= $rowgetuser['Course'];
                        echo "<tr><td>Course:</td>
                        <td><select id=\"editCourse\" name=\"editCourse\" required>
                        <option value=\"Data Science and Economics\">Data Science and Economics</option>
                        <option value=\"Food Science and Technology\">Food Science and Technology</option>
                        <option value=\"Humanities Sciences\">Humanities Sciences</option>
                        <option value=\"Pharmaceutical Science\">Pharmaceutical Science</option>
                        <option value=\"Philosophy, Politics, Economics\">Philosophy, Politics, Economics</option>
                        <option value=\"Architecture\">Architecture</option>
                        <option value=\"Industrial Design\">Industrial Design</option>
                        <option value=\"Landscape Architecture\">Landscape Architecture</option>
                        <option value=\"Project & Facilities\">Project & Facilities</option>
                        <option value=\"Real Estate\">Real Estate</option>
                        <option value=\"Biomedical Engineering\">Biomedical Engineering</option>
                        <option value=\"Civil Engineering\">Civil Engineering</option>
                        <option value=\"Chemical Engineering\">Chemical Engineering</option>
                        <option value=\"Engineering Science\">Engineering Science</option>
                        <option value=\"Environmental Engineering\">Environmental Engineering</option>
                        <option value=\"Electrical Engineering\">Electrical Engineering</option>
                        <option value=\"Mechanical Engineering\">Mechanical Engineering</option>
                        <option value=\"Industrial and Systems Engineering\">Industrial and Systems Engineering</option>
                        <option value=\"Material Science Engineering\">Material Science Engineering</option>
                        <option value=\"Business Administration (Accountancy)\">Business Administration (Accountancy)</option>
                        <option value=\"Information Security\">Information Security</option>
                        <option value=\"Computer Science\">Computer Science</option>
                        <option value=\"Information System\">Information System</option>
                        <option value=\"Business Analytics\">Business Analytics</option>
                        <option value=\"Computer Engineering\">Computer Engineering</option>
                        <option value=\"Dentistry\">Dentistry</option>
                        <option value=\"Undergraduate Law Programme\">Undergraduate Law Programme</option>
                        <option value=\"Medicine\">Medicine</option>
                        <option value=\"Nursing\">Nursing</option>
                        <option value=\"Pharmacy\">Pharmacy</option>
                        <option value=\"Music\">Music</option>
                        </select></td>";
                        echo "<input id=\"HidCourse\" type=\"text\" value=\"$course\" hidden>";
                        echo "</tr>";

                        //edit year of study
                        $yearofstudy = $rowgetuser['YearOfStudy'];
                        echo "<tr><td>Year of Study:</td>
                        <td><select id=\"editYearOfStudy\" name=\"editYearOfStudy\" required>
                        <option value=\"1\">1</option>
                        <option value=\"2\">2</option>
                        <option value=\"3\">3</option>
                        <option value=\"4\">4</option>
                        <option value=\"5\">5</option>
                        </select></td>";
                        echo "<input id=\"HidYearOfStudy\" type=\"number\" value=\"$yearofstudy\" hidden>";
                        echo "</tr>";

                        //edit bio
                        $bio = $rowgetuser['Bio'];
                        echo "<tr><td>Bio:</td>
                        <td><textarea cols=\"30\" rows=\"10\" name=\"editBio\" maxlength=\"200\">$bio</textarea></td>";
                        echo "</tr>";

                        //edit residency stat
                        $residencystat= $rowgetuser['ResidencyStatus'];
                        echo "<tr><td>Residency:</td>
                        <td><select id=\"editResidency\" name=\"editResidency\" required>
                        <option value=\"No\">Does not stay in campus</option>
                        <option value=\"Yes\">Stays in campus</option>
                        </select></td>";
                        echo "<input id=\"HidResidency\" type=\"text\" value=\"$residencystat\" hidden>";
                        echo "</tr>";

                        $currentmod= $rowgetuser['CurrentMod'];
                        echo "<tr><td>Current Mods:</td>
                        <td><textarea cols=\"30\" rows=\"10\" name=\"editCurrentMod\" maxlength=\"300\">$currentmod</textarea></td>";
                        echo "</tr>";

                        $pastmod= $rowgetuser['PastMod'];
                        echo "<tr><td>Past Mods:</td>
                        <td><textarea cols=\"30\" rows=\"10\" name=\"editPastMod\" maxlength=\"300\">$pastmod</textarea></td>";
                        echo "</tr>";

                        $cca= $rowgetuser['CCA'];
                        echo "<tr><td>CCAs/Clubs:</td>
                        <td><textarea cols=\"30\" rows=\"10\" name=\"editCCA\" maxlength=\"300\">$cca</textarea></td>";
                        echo "</tr>";

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
            <div>
                <button type="submit" id="confirmbutton" name="confirmbutton">Confirm changes</button>
            </div>
            </form>
        </section>
    </section>
    <?php
     $nusemail= $_SESSION['NUSEmail'];
    if (isset($_POST['confirmbutton'])){
        $imagetoken = bin2hex(random_bytes(15));//Generate unique random token to append to imagename
        if(!$_FILES['newProfilePicture']['name']==""){ //something is uploaded
            $filebasename= $imagetoken.basename($_FILES["newProfilePicture"]["name"]);
            $target_dir = $_SERVER['DOCUMENT_ROOT'].'/orbital/userprofilepic';//$_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/dt-the7/trainerprofilepicture';
            $target_file = $target_dir . '/' . $filebasename;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["newProfilePicture"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
            
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["newProfilePicture"]["size"] > 50000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                exit();
            // if everything is ok, try to upload file
            } 
            else {
                if (move_uploaded_file($_FILES["newProfilePicture"]["tmp_name"], $target_file)) {
                    echo "The file ". $filebasename. " has been uploaded.";
                } 
                else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            
            $imagename=$filebasename;
            
            //end of image upload
            $sqlupdatepic="UPDATE users SET ProfilePic='$imagename' WHERE NUSEmail='$nusemail'";
            $resultupdatepic=mysqli_query($conn,$sqlupdatepic);
            
            
            $thelastfilename=$_POST['userLastProfilePic'];
            if($thelastfilename!="" || $thelastfilename!=NULL){ //just upload a new one, if the last file name have, then unlink that file
                unlink( $_SERVER['DOCUMENT_ROOT']."/orbital/userprofilepic/$thelastfilename");
            }
        }
        if(!empty($_POST['editFullName'])){
            $newfullname = mysqli_real_escape_string($conn, $_POST['editFullName']);//sanitize
            $sqlupdateuser="UPDATE users SET FullName='$newfullname' WHERE NUSEmail='$nusemail'";
            $resultupdateuser=mysqli_query($conn,$sqlupdateuser);
        }
        if(!empty($_POST['editCourse'])){
            $newcourse = mysqli_real_escape_string($conn,$_POST['editCourse']);//sanitize
            $sqlupdateuser="UPDATE users SET Course='$newcourse' WHERE NUSEmail='$nusemail'";
            $resultupdateuser=mysqli_query($conn,$sqlupdateuser);
        }
        if(!empty($_POST['editYearOfStudy'])){
            $newyearofstudy = mysqli_real_escape_string($conn,$_POST['editYearOfStudy']);//sanitize
            $sqlupdateuser="UPDATE users SET YearOfStudy='$newyearofstudy' WHERE NUSEmail='$nusemail'";
            $resultupdateuser=mysqli_query($conn,$sqlupdateuser);
        }
        if(!empty($_POST['editBio'])){
            $newBio = mysqli_real_escape_string($conn, $_POST['editBio']);//sanitize
            $sqlupdateuser="UPDATE users SET Bio='$newBio' WHERE NUSEmail='$nusemail'";
            $resultupdateuser=mysqli_query($conn,$sqlupdateuser);
        }
        if(!empty($_POST['editResidency'])){
            $newResidency = mysqli_real_escape_string($conn,$_POST['editResidency']);//sanitize
            $sqlupdateuser="UPDATE users SET ResidencyStatus='$newResidency' WHERE NUSEmail='$nusemail'";
            $resultupdateuser=mysqli_query($conn,$sqlupdateuser);
        }
        if(!empty($_POST['editCurrentMod'])){
            $newCurrentMod = mysqli_real_escape_string($conn,$_POST['editCurrentMod']);//sanitize
            $sqlupdateuser="UPDATE users SET CurrentMod='$newCurrentMod' WHERE NUSEmail='$nusemail'";
            $resultupdateuser=mysqli_query($conn,$sqlupdateuser);
        }
        if(!empty($_POST['editPastMod'])){
            $newPastMod = mysqli_real_escape_string($conn,$_POST['editPastMod']);//sanitize
            $sqlupdateuser="UPDATE users SET PastMod='$newPastMod' WHERE NUSEmail='$nusemail'";
            $resultupdateuser=mysqli_query($conn,$sqlupdateuser);
        }
        if(!empty($_POST['editCCA'])){
            $newCCA = mysqli_real_escape_string($conn,$_POST['editCCA']);//sanitize
            $sqlupdateuser="UPDATE users SET CCA='$newCCA' WHERE NUSEmail='$nusemail'";
            $resultupdateuser=mysqli_query($conn,$sqlupdateuser);
        }

        // Redirect them to the profile page
        if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
            header("Location: http://localhost/orbital/profile.php");
        }
        else{
            header("Location: http://localhost:8080/orbital/profile.php");
        } 
    }
    ?>
    <script>
        //profile picture uploads
        function clickonFile(){
            document.getElementById("newProfilePicture").click();
        }
        var loadFile = function(event) {
            document.getElementById("output").removeAttribute("hidden");
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            document.getElementById("profilepic").setAttribute("hidden","hidden");
        };

        //populating select fields
        actualcourse=document.getElementById("HidCourse").value;
        actualyearofstudy=document.getElementById("HidYearOfStudy").value;
        actualresidency=document.getElementById("HidResidency").value;

        function populateSelectFields(){
            //course
            getcourse=document.getElementById("editCourse");
            for(c=0; c < getcourse.length; c++){
                theoptionvalues1=getcourse.options[c].value; //the value in the select dropdown
                if(actualcourse==theoptionvalues1){
                    document.getElementById("editCourse").value=actualcourse;
                }
            }
            //yearofstudy
            getyearofstudy=document.getElementById("editYearOfStudy");
            for(y=0; y < getyearofstudy.length; y++){
                theoptionvalues2=getyearofstudy.options[y].value; //the value in the select dropdown
                if(actualyearofstudy==theoptionvalues2){
                    document.getElementById("editYearOfStudy").value=actualyearofstudy;
                }
            }

            //residency
            getresidency=document.getElementById("editResidency");
            for(r=0; r < getresidency.length; r++){
                theoptionvalues3=getresidency.options[r].value; //the value in the select dropdown
                if(actualresidency==theoptionvalues3){
                    document.getElementById("editResidency").value=actualresidency;
                }
            }

        }
    </script>
</body>
</html>
