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
    <title>StudyLah</title>
</head>
<style>
    #searchsection{
    text-align:center;
    display:block;
    width:70%;
    border-left:1px solid rgba(0, 0, 0, 0.3);
    border-right:1px solid rgba(0, 0, 0, 0.3);
    box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.3);
    margin:0 auto;
    background-color:white;
    padding-top: 60px;
}
#profilepic{
    border-radius:50%;
    padding:30px;
}

#profilebio{
    font-style:italic;
    text-align:center;
    width:250px;
    margin:30px auto;
}

.bigtext{
    padding:20px;
    font-size:30px;
    text-decoration:underline;
}

.hrstyle{
    width:50%;
    margin-top:15px;
    margin-bottom:15px;
}

.centertable{
    margin-left:auto;
    margin-right:auto;
    padding:20px;
}

tr, td{
    padding:15px;
    text-align:left;
    border-bottom:1px solid #bfbfbf;
}
.tablerows:hover{
    opacity:0.7;
    cursor:pointer;
}

.tdsecond{
    color:gray;
}

.userprofilepic{
    border-radius:50%;
}

#searchimg{
    margin-right:10px;
}
</style>
<body style="font-family:'Inter',sans-serif;">
    <!--navbar-->
    <?php include('header.php');?>
    <!--profile section-->
    <section style="background-color:#424240;">
        <section id="searchsection">
            <div>
                <div class="bigtext"><img src="img/search.png" width="20px" height="20px" id="searchimg">Search Users</div>
                <div>
                    <input type="text" id="searchNameInput" onkeyup="searchName()" placeholder="Search by name...">
                    <input type="text" id="searchModInput" onkeyup="searchMod()" placeholder="Search by a current mod...">
                    <select name="Course" class="input-field" id="searchCourseInput" onchange="searchCourse()" required>
                        <option selected value="All Course">All Course</option>
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
                </div>
                <br><br>
                <div>
                    <select name="Gender" class="input-field" id="searchGenderInput" onchange="searchGender()" required>
                        <option selected value="All Gender">All Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                    </select>
                    <select name="YearOfStudy" class="input-field" id="searchYearInput" onchange="searchYear()" required>
                        <option selected value="Any Year of Study">Any Year of Study</option>
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
                        <option value="4">Year 4</option>
                        <option value="5">Year 5</option>
                    </select>
                    <input type="text" id="searchCCAInput" onkeyup="searchCCA()" placeholder="Search by CCA...">
                    <button type="button" id="clearfilters">Clear Filters</button>
                </div>
                <br><br>
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

                $currentuseremail=$_SESSION['NUSEmail'];
                $sqlgetuser="SELECT * FROM users WHERE NOT NUSEmail='$currentuseremail' ORDER BY UserID ASC";//dont show myself
                $resultgetuser=mysqli_query($conn,$sqlgetuser);
                echo "<table class=\"centertable\" id=\"usersTable\">";
                echo "<tr style=\"font-weight:bold;\"><td></td><td>Name</td><td>Gender</td><td>Course</td><td>Year of Study</td><td>Current Mods</td><td>CCA</td></tr>";
                if(mysqli_num_rows($resultgetuser) > 0){//get users
                    while($rowgetuser=mysqli_fetch_array($resultgetuser)){
                        $userprofilepic=$rowgetuser['ProfilePic'];
                        $userid=$rowgetuser['UserID'];
                        echo "<form method=\"post\" action=\"viewusers.php\" id=\"userform$userid\">";//submit form onclick of row
                        echo "<tr class=\"tablerows\" onclick=\"document.getElementById('userform$userid').submit();\">";
                        if($userprofilepic == "" || $userprofilepic == NULL){
                            echo "<td><img src=\"img/user.png\" width=\"100px\" height=\"100px\" class=\"userprofilepic\"></td>";
                        }
                        else{
                            echo "<td><img src=\"userprofilepic/$userprofilepic\" width=\"100px\" height=\"100px\" class=\"userprofilepic\"></td>";
                        }

                        echo "<td>".$rowgetuser['FullName']."<input type=\"number\" value=\"$userid\" name=\"theuserid\" hidden></td>";
                        echo "<td>".$rowgetuser['Gender']."</td>";
                        echo "<td>".$rowgetuser['Course']."</td>";
                        echo "<td>Year ".$rowgetuser['YearOfStudy']."</td>";
                        $currentmods = $rowgetuser['CurrentMod'];
                        $currentmodsexplode=preg_split('/[\ \n\,]+/', $currentmods);//split string by regular expressions e.g comma, space
                        echo "<td>";
                        for($eachcurrmod = 0; $eachcurrmod < count($currentmodsexplode); $eachcurrmod++){
                            $getcurrmods=$currentmodsexplode[$eachcurrmod];
                            echo "$getcurrmods<br>";
                        }
                        echo "</td>";

                        //cca
                        $currentcca = $rowgetuser['CCA'];
                        if($currentcca == NULL || $currentcca == ""){
                            echo "<td>";
                            echo "No CCA";
                            echo "</td>";
                        }
                        else{
                            $currentccasexplode = preg_split('/[\ \n\,]+/', $currentcca);
                            echo "<td>";
                            for($eachcurrcca = 0; $eachcurrcca < count($currentccasexplode); $eachcurrcca++){
                                $getcurrcca=$currentccasexplode[$eachcurrcca];
                                echo "$getcurrcca<br>";
                            }
                            echo "</td>";
                        }
                        echo "</tr>";
                        echo "<button type=\"submit\" name=\"eachuserprofile\" hidden></button>";
                        echo "</form>";
                    }
                }
                else{
                    echo "<div>No other users...</div>";
                }
                echo "</table>";
                ?>
            </div>
        </section>
    </section>
</body>
<script>
    function searchName() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchNameInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
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
    function searchMod() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchModInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[5]; //get current mod
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

    function searchCourse() {
        var input, table, tr, td, i, txtValue;
        input = document.getElementById("searchCourseInput").value;
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            if(input == "All Course"){
                tr[i].style.display = "";
            }
            else{
                td = tr[i].getElementsByTagName("td")[3]; //get course
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.indexOf(input) > -1) {
                        tr[i].style.display = "";
                    } 
                    
                    else {
                        tr[i].style.display = "none";
                    }
                }	
            }
        }
    }

    function searchGender() {
        var input, table, tr, td, i, txtValue;
        input = document.getElementById("searchGenderInput").value;
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            if(input == "All Gender"){
                tr[i].style.display = "";
            }
            else{
                td = tr[i].getElementsByTagName("td")[2]; //get gender
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.indexOf(input) > -1) {
                        tr[i].style.display = "";
                    } 
                    
                    else {
                        tr[i].style.display = "none";
                    }
                }	
            }
        }
    }

    function searchYear() {
        var input, table, tr, td, i, txtValue;
        input = document.getElementById("searchYearInput").value;
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            if(input == "Any Year of Study"){
                tr[i].style.display = "";
            }
            else{
                td = tr[i].getElementsByTagName("td")[4]; //get YOS
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.indexOf(input) > -1) {
                        tr[i].style.display = "";
                    } 
                    
                    else {
                        tr[i].style.display = "none";
                    }
                }	
            }
        }
    }

    function searchCCA(){
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchCCAInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[6]; //get CCA
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

    // Get the button that clear filters
    var btn = document.getElementById("clearfilters");

    // When the user clicks the button, clear filters
    btn.onclick = function() {
        document.getElementById("searchNameInput").value = "";
        document.getElementById("searchModInput").value = "";
        var dropDown1 = document.getElementById("searchCourseInput");
        dropDown1.selectedIndex = 0;
        var dropDown2 = document.getElementById("searchGenderInput");
        dropDown2.selectedIndex = 0;
        var dropDown3 = document.getElementById("searchYearInput");
        dropDown3.selectedIndex = 0;
        document.getElementById("searchCCAInput").value = "";

        var table, tr, td, i;
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = "";
        }
    }
    </script>
</html>
