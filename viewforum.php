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
    <link rel="stylesheet" href="css\message.css">
    <title>StudyLah</title>
</head>
<style>
#theforums{
        margin:0 auto;
        border-collapse:separate;
        border-spacing:0;
        width:70%;
        vertical-align:top;
    }

    #replytable{
        margin:0 auto;
        border-collapse:separate;
        border-spacing:0;
        width:70%;
        vertical-align:top;
        padding-left:20px;
    }

    tr, td{
        padding:20px;
        text-align:left;
        border-bottom:1px solid #bfbfbf;
        border-collapse:separate;
        border-spacing:0;
        vertical-align:top;
    }

    .profalign{
        text-align:right;

    }

    .groupprofilepic{
        border-radius:50%;
    }

    .theforumtitle{
        font-weight:bold;
        font-size:20px;
    }

    #submitReplyButton{
        background-color:black;
        color:white;
        padding:5px 7px;
        border:none;
        border-radius:5px;
        margin-left:10px;
    }

    #submitReplyButton:hover{
        opacity:0.7;
        cursor:pointer;
    }

    .backbutton{
        text-align:left;
        margin-left:30px;
    }
    .backbutton:hover{
        cursor:pointer;
        opacity:0.7;
    }

    #deleteforum:hover{
        opacity:0.7;
        cursor:pointer;
    }

    /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 70%;
    }

    /* The Close Button */
    .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    }

    .close:hover,
    .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    }

    .decoratebuttons{
        background-color:black;
        color:white;
        padding:5px 7px;
        border:none;
        border-radius:5px;
    }
    .decoratebuttons:hover{
        opacity:0.7;
        cursor:pointer;
    }
    </style>
<body style="font-family: 'Inter', sans-serif;">
    <!--navbar-->
    <?php include('header.php');?>
    <!--message section-->
    <section style="background-color:#424240;">
        <section id="messagesection">
            <div>
            <div>
                <?php
                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                    echo "<div class=\"backbutton\" onclick=\"window.location.href='http://localhost/orbital/forum.php'\"><img src=\"img/back.png\" width=\"15px\" height=\"15px\" class=\"backpic\">Back</div>";//back button
                }
                else{
                    echo "<div class=\"backbutton\" onclick=\"window.location.href='http://localhost:8080/orbital/forum.php'\"><img src=\"img/back.png\" width=\"15px\" height=\"15px\" class=\"backpic\">Back</div>";//back button
                }
                ?>
                </div>
                <div class="bigtext">View Forum </div>
                <!--delete forum - only seeable by owner-->
                <div>
                </div>
                <div style="margin-bottom:30px;"></div>
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
                $timestamp=date('Y-m-d H:i:s');//timestamp format

                $getforum = $_GET['forum'];
                if($getforum == '' || $getforum == NULL){
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        $url="http://localhost/orbital/error.php?error=forumdoesnotexist";
                        header('Location:' . $url);
                    }
                    else{
                        $url="http://localhost:8080/orbital/error.php?error=forumdoesnotexist";
                        header('Location:' . $url);
                    }
                }
                else if (preg_match("/[a-z]/i", $getforum)){
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        $url="http://localhost/orbital/error.php?error=forumdoesnotexist";
                        header('Location:' . $url);
                    }
                    else{
                        $url="http://localhost:8080/orbital/error.php?error=forumdoesnotexist";
                        header('Location:' . $url);
                    }
                }
                else{//ok
            
                    $sqlfetchforum = "SELECT * FROM forum WHERE ForumID='$getforum' AND ReplyToID='0'";//main
                    $resultfetchforum = mysqli_query($conn, $sqlfetchforum);

                    if(mysqli_num_rows($resultfetchforum) > 0){//exist forum
                        while($rowfetchforum = mysqli_fetch_array($resultfetchforum)){

                            //show delete button for owners only
                            $theownerofforumid = $rowfetchforum['UserID'];
                            //now fetch that user's email
                            $sqlfetchuseremail = "SELECT * FROM users WHERE UserID='$theownerofforumid'";
                            $resultfetchuseremail = mysqli_query($conn,$sqlfetchuseremail);

                            while($rowfetchuseremail = mysqli_fetch_array($resultfetchuseremail)){
                                $thecurruseremail = $rowfetchuseremail['NUSEmail'];
                                if($thecurruseremail == $_SESSION['NUSEmail']){
                                    echo "<img src=\"img/delete.png\" width=\"25px\" height=\"25px\" alt=\"deleteforum\" id=\"deleteforum\">";
                                }
                            }

                            echo "<table id=\"theforums\">";
                            echo "<tr>";
                            //main forum
                            $theuserid = $rowfetchforum['UserID'];
                            //fetch user
                            $sqlgetuser = "SELECT * FROM users WHERE UserID='$theuserid'";
                            $resultgetuser = mysqli_query($conn,$sqlgetuser);

                            while($rowgetuser = mysqli_fetch_array($resultgetuser)){
                                $profilepic = $rowgetuser['ProfilePic'];
                                $userid = $rowgetuser['UserID'];
                                echo "<form method=\"post\" action=\"viewusers.php\" id=\"userform$userid\">";
                                if($profilepic == NULL || $profilepic == ""){
                                    echo "<td class=\"profalign\" onclick=\"document.getElementById('userform$userid').submit();\"><img src=\"img/user.png\" width=\"40px\" height=\"40px\" alt=\"profilepic\" class=\"groupprofilepic\"></td>";
                                }
                                else{
                                    echo "<td class=\"profalign\" onclick=\"document.getElementById('userform$userid').submit();\"><img src=\"userprofilepic/$profilepic\" width=\"40px\" height=\"40px\" alt=\"profilepic\" class=\"groupprofilepic\"></td>";
                                }
                                echo "<input type=\"number\" value=\"$userid\" name=\"theuserid\" hidden>";
                                echo "<td><span style=\"font-size:15px;color:gray;\">".$rowgetuser['FullName']."&nbsp&nbsp ".$rowfetchforum['Timing']."</span>";
                                echo "</form>";
                            }

                            echo "<br><br><span class=\"theforumtitle\">".$rowfetchforum['Title']."</span>
                            <br><br>".$rowfetchforum['Message']."</td>";
                            echo "</tr>";
                            echo "</table>";
                        }
                    }
                    else{
                        if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                            $url="http://localhost/orbital/error.php?error=forumdoesnotexist";
                            header('Location:' . $url);
                        }
                        else{
                            $url="http://localhost:8080/orbital/error.php?error=forumdoesnotexist";
                            header('Location:' . $url);
                        }
                    }
                    
                    echo "<hr>";

                    //see replies from users
                    echo "<div style=\"text-align:left; padding:20px;text-decoration:underline;\">Replies:</div>";
                    echo "<div>";
                    $sqlfetchreply = "SELECT * FROM forum WHERE ReplyToID = '$getforum' ORDER BY ForumID ASC";
                    $resultfetchreply = mysqli_query($conn,$sqlfetchreply);

                    if(mysqli_num_rows($resultfetchreply) > 0){ //got replies
                        echo "<table id=\"replytable\">";
                        while($rowfetchreply = mysqli_fetch_array($resultfetchreply)){
                            echo "<tr>";
                            $replyuserid=$rowfetchreply['UserID'];
                            //fetch user
                            $sqlfetchreplyuser = "SELECT * FROM users WHERE UserID = '$replyuserid'";
                            $resultfetchreplyuser = mysqli_query($conn,$sqlfetchreplyuser);

                            while($rowfetchreplyuser = mysqli_fetch_array($resultfetchreplyuser)){
                                $replyprofilepic = $rowfetchreplyuser['ProfilePic'];
                                if($replyprofilepic == NULL || $replyprofilepic == ''){
                                    echo "<td class=\"profalign\"><img src=\"img/user.png\" width=\"40px\" height=\"40px\" alt=\"profilepic\" class=\"groupprofilepic\"></td>";
                                }
                                else{
                                    echo "<td class=\"profalign\"><img src=\"userprofilepic/$replyprofilepic\" width=\"40px\" height=\"40px\" alt=\"profilepic\" class=\"groupprofilepic\"></td>";
                                }

                                echo "<td><span style=\"font-size:15px;color:gray;\">".$rowfetchreplyuser['FullName']."&nbsp&nbsp ".$rowfetchreply['Timing']."</span>";
                            }
                            echo "<br><br>".$rowfetchreply['Message']."";
                            echo "<tr>";
                        }
                        echo "<table>";
                    }
                    else{
                        echo "<div>No replies yet...</div>";
                    }

                    echo "</div>";

                    //to reply
                    echo "<div style=\"margin-top:30px;\"></div>";
                    echo "<form method=\"post\">";
                    echo "<textarea cols=\"50\" rows=\"5\" placeholder=\"Type reply\" name=\"replyForum\" required></textarea>";
                    echo "<button type=\"submit\" name=\"submitReply\" id=\"submitReplyButton\">Reply</button>";
                    echo "</form>";

                    if(isset($_POST['submitReply'])){
                        $thereply = $_POST['replyForum'];
                        //get curr user details
                        $sqlfetchuser = "SELECT * FROM users WHERE NUSEmail ='$useremail'";
                        $resultfetchuser = mysqli_query($conn,$sqlfetchuser);

                        while($rowfetchuser = mysqli_fetch_array($resultfetchuser)){
                            $userid = $rowfetchuser['UserID'];
                            $userfullname = $rowfetchuser['FullName'];

                            //insert into reply forum
                            $sqlinsertreply = "INSERT INTO forum (UserID, NUSEmail,FullName,Title,Message,Timing,ReplyToID)
                            VALUES ('$userid','$useremail','$userfullname','-','$thereply','$timestamp','$getforum')";
                            $resultinsertreply = mysqli_query($conn,$sqlinsertreply);

                            //redirect
                            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                                $url="http://localhost/orbital/viewforum.php?forum=$getforum";
                                header('Location:' . $url);
                            }
                            else{
                                $url="http://localhost:8080/orbital/viewforum.php?forum=$getforum";
                                header('Location:' . $url);
                            }
                        }
                    }
                }
                ?>
            </div>
            <!-- The Modal -->
            <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
            <span class="close">&times;</span>
            <p>Are you sure you want to delete your post?</p>
            <div style="margin-top:20px;"><button type="button" id="closepost" class="decoratebuttons">No</button>&nbsp;&nbsp;
            <form method="post" style="display:inline-block;"><button type="submit" name="deletePost" class="decoratebuttons">Yes</button></form></div>
            <?php
            if(isset($_POST['deletePost'])){
                $sqldeletechildreply = "DELETE FROM forum WHERE ReplyToId='$getforum'";
                $resultdeletechildreply=mysqli_query($conn,$sqldeletechildreply);

                $sqldeleteforum = "DELETE FROM forum WHERE ForumID='$getforum'";
                $resultdeleteforum = mysqli_query($conn,$sqldeleteforum);

                //redirect
                if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                    $url="http://localhost/orbital/forum.php";
                    header('Location:' . $url);
                }
                else{
                    $url="http://localhost:8080/orbital/forum.php";
                    header('Location:' . $url);
                }
            }
            ?>
            </div>
            </div>
        </section>
    </section>
</body>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("deleteforum");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var closepost = document.getElementById("closepost");

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

closepost.onclick = function(){
    modal.style.display= "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</html>
