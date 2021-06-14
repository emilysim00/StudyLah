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
    <link rel="stylesheet" href="css\createmessage.css">
    <title>StudyLah</title>
</head>
<body>
    <!--navbar-->
    <?php include('header.php');?>
    <!--message section-->
    <section style="background-color:#424240;">
        <section id="messagesection">
            <div>
                <div class="bigtext">Create Message</div>
                <form method="post" enctype="multipart/form-data">
                    <div>Chat Name:</div>
                    <input type="text" name="groupName" required><br><br>
                    <div>Chat Pic:</div>
                    <input type="file" id="groupPic" name="groupPic" onchange="loadFile(event)"/>
                    <div><img id="output" width="150px" height="150px" style="border-radius:50%;" hidden/></div><br><br>
                    <div>Members: <span id="membersadded"></span></div><br><br>
                    <div><input type="text" id="finalmember" name="finalMember" hidden></div><!--hid-->
                    <button type="submit" name="createGroup" id="creategroupbutton" disabled>Create group</button>
                </form><br><br>
                <div>Search: <input type="text" id="searchNameInput" onkeyup="searchName()" placeholder="Add members by name.."></div><br>
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
                $myemail = $_SESSION['NUSEmail'];
                
                //add friends table list
                echo "<table id=\"usersTable\">";
                $displayfriend = "SELECT * FROM users";
                $resultfriend = mysqli_query($conn, $displayfriend);

                while ($rowfriend = mysqli_fetch_array($resultfriend)) {
                    $checkcurrentuser = $rowfriend['NUSEmail'];

                    if ($checkcurrentuser != $myemail){//do not display myself in the table...
                        echo "<tr>";
                        $profilepic=$rowfriend['ProfilePic'];
                        if($profilepic=="" || $profilepic==NULL){
                            echo "<td><img src=\"img/user.png\" width=\"60px\" height=\"60px\" id=\"userpic\"></td>";
                        }
                        else{
                            echo "<td><img src=\"userprofilepic/$profilepic\" width=\"60px\" height=\"60px\" id=\"userpic\"></td>";
                        }
                        echo "<td>".$rowfriend['FullName']."</td>";
                        echo "<td>".$rowfriend['NUSEmail']."</td>";
                        echo "<td id=\"rowdata".$rowfriend['NUSEmail']."\"><img src=\"img/add-button.png\" width=\"20px\" height=\"20px\" id=\"".$rowfriend['NUSEmail']."\" onclick=\"addthisfriend(this.id)\" class=\"addfriendbutton\"></td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";

                ?>
            </div>
        </section>
    </section>
</body>
<?php
$timestamp=date('Y-m-d H:i:s');//timestamp format
if (isset($_POST['createGroup'])){
    $groupname= $_POST['groupName'];
    $imagename = "";
    if(!$_FILES['groupPic']['name']==""){ //something is uploaded
        $target_dir = $_SERVER['DOCUMENT_ROOT'].'/orbital/grouppic';
        $target_file = $target_dir . '/' . basename($_FILES["groupPic"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["groupPic"]["tmp_name"]);
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
        if ($_FILES["groupPic"]["size"] > 50000000) {
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
            if (move_uploaded_file($_FILES["groupPic"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["groupPic"]["name"]). " has been uploaded.";
            } 
            else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        
        $imagename=basename( $_FILES["groupPic"]["name"]);
    }

    //insert into groups
    $sqlgethighestgroupid = "SELECT MAX(GroupID) FROM groups";
    $resultmaxgroupid = mysqli_query($conn, $sqlgethighestgroupid);

    if(mysqli_num_rows($resultmaxgroupid) > 0){//valid
        while($rowmaxgroup=mysqli_fetch_array($resultmaxgroupid)){
            $maxgroup = $rowmaxgroup["MAX(GroupID)"] + 1;
        }
    }
    else{
        $maxgroup = 1;
    }

    //insert new group
    $sqlinsert1="INSERT INTO groups (GroupName, GroupPic)
    VALUES ('$groupname','$imagename');";
    $result1=mysqli_query($conn,$sqlinsert1);

    //insert current user (myself) into the group---------------------------------
    $sqlgetmyself="SELECT * FROM users WHERE NUSEmail='$myemail'";
    $resultgetmyself=mysqli_query($conn,$sqlgetmyself);

    while($rowgetmyself=mysqli_fetch_array($resultgetmyself)){
        $myuserid = $rowgetmyself['UserID'];
        $myfullname = $rowgetmyself['FullName'];
        $sqlinsertmyself="INSERT INTO messages (UserID, GroupID, NUSEmail, FullName, Timing)
        VALUES ('$myuserid','$maxgroup','$myemail','$myfullname','$timestamp');";
        $resultmyself=mysqli_query($conn,$sqlinsertmyself);
    }

    //insert other users apart from myself ----------------------------------------------
    $finalmembers = $_POST['finalMember'];
    //insert new message default in group
    $memberexplode=explode(",", $finalmembers);//split by comma
    for($eachmem = 0;$eachmem < count($memberexplode); $eachmem++){
        $getmem=$memberexplode[$eachmem];//this is their email
       
        $sqlgetuser="SELECT * FROM users WHERE NUSEmail='$getmem'";
        $resultgetuser=mysqli_query($conn,$sqlgetuser);

        if(mysqli_num_rows($resultgetuser) > 0){//valid user
            while($rowgetuser=mysqli_fetch_array($resultgetuser)){
                $getuserid = $rowgetuser['UserID'];
                $getfullname = $rowgetuser['FullName'];

                //insert other users
                $sqlinsert2="INSERT INTO messages (UserID, GroupID, NUSEmail, FullName, Timing)
                VALUES ('$getuserid','$maxgroup','$getmem','$getfullname','$timestamp');";
                $result2=mysqli_query($conn,$sqlinsert2);

                //insert into other users notifications - just added "You are added into..."
                $sqlinsertnotification = "INSERT INTO messagenotifications (GroupID,NUSEmail,NotificationType,Timing,Status,Message)
                VALUES ('$maxgroup','$getmem','NewAdded','$timestamp','Unseen','You are added into $groupname')";
                $resultinsertnotification= mysqli_query($conn,$sqlinsertnotification);

            }
        }
        else{
            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                $url="http://localhost/orbital/error.php?error=unknown";
                header('Location:' . $url);
            }
            else{
                $url="http://localhost:8080/orbital/error.php?error=unknown";
                header('Location:' . $url);
            }
        }
    }

     // Redirect them to the message chat
     if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
        header("Location: http://localhost/orbital/seemessage.php?group=$maxgroup");
    }
    else{
        header("Location: http://localhost:8080/orbital/seemessage.php?group=$maxgroup");
    } 
}

?>
<script>
    var loadFile = function(event) {
        document.getElementById("output").removeAttribute("hidden");
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    function searchName() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchNameInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; //get Name
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } 
                
                else {
                    tr[i].style.display = "none";
                }
            }	
        }
    }

    function addthisfriend(clicked_id){
        document.getElementById("membersadded").innerHTML += "<div id=\"add"+clicked_id+"\">"+clicked_id+"&nbsp&nbsp<span class=\"hovercross\" id=\"cross"+clicked_id+"\" onclick=\"removefriend(this.id)\">&times</span></div>";
        document.getElementById(clicked_id).remove();
        //add to final input

        if(document.getElementById("finalmember").value == ""){
            document.getElementById("finalmember").value = clicked_id;
        }
        else{
            document.getElementById("finalmember").value += ","+clicked_id;
        }

        document.getElementById("creategroupbutton").removeAttribute("disabled","");

    }

    function removefriend(friendid){
        var originalid= friendid.slice(5);
        document.getElementById("add"+originalid).remove();
        document.getElementById("rowdata"+originalid).innerHTML = "<img src=\"img/add-button.png\" width=\"20px\" height=\"20px\" id=\""+originalid+"\" onclick=\"addthisfriend(this.id)\" class=\"addfriendbutton\">";
        
        //remove from final input
        var str = document.getElementById("finalmember").value;
        var getIndex = str.indexOf(originalid);//get index
        var lengthofremovedstring = originalid.length;

        //remove comma infront
        if ((getIndex - 1) >= 0){
            str = str.split('');
            str[getIndex-1]='';
            str=str.join('');
        }
        
        //remove comma behind
        str = str.split('');
        str[lengthofremovedstring+getIndex] = '';
        str= str.join('');

        var replaced = str.replace(originalid, "");
        document.getElementById("finalmember").value = replaced;

        if(document.getElementById("creategroupbutton").value == ""){
            document.getElementById("creategroupbutton").setAttribute("disabled","");
        }
    }
</script>
</html>