<style>
.logoutbutton{
    vertical-align:middle;
    background-color: #5d4954;
    color:white;
    border:none;
}

.logoutbutton:hover{
    cursor:pointer;
    opacity:0.7;
}
</style>
<nav>
    <div class="logo">StudyLah</div>
    <ul class="nav-links">
        <li>
            <?php
            //search
            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                echo "<a href=\"http://localhost/orbital/searchusers.php\"><img src=\"img/search-white.png\" width=\"20px\" height=\"20px;\" alt=\"Search\"></a>";
            }
            else{
                echo "<a href=\"http://localhost:8080/orbital/searchusers.php\"><img src=\"img/search-white.png\" width=\"20px\" height=\"20px;\" alt=\"Search\"></a>";
            } 
            ?>
        </li>
        <li>
            <?php
            //Home
            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                echo "<a href=\"http://localhost/orbital/dashboard.php/\">Home</a>";
            }
            else{
                echo "<a href=\"http://localhost:8080/orbital/dashboard.php/\">Home</a>";
            } 
            ?>
        </li>
        <li>
            <?php
            //Messages
            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                echo "<a href=\"http://localhost/orbital/message.php\">Chats</a>";
            }
            else{
                echo "<a href=\"http://localhost:8080/orbital/message.php\">Chats</a>";
            } 
            ?>
        </li>
        <li><a href="#">Others</a>
            <ul class="dropdown">
                <li>
                    <?php
                    //forum
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/forum.php\">Forum</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/forum.php\">Forum</a>";
                    } 
                    ?>
                </li>
                <li>
                    <?php
                    //Profile
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/schedule.php\">Add Schedule</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/schedule.php\">Add Schedule</a>";
                    } 
                    ?>
                </li>
                <li>
                    <?php
                    //add tasks
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/addtask.php\">Add Task</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/addtask.php\">Add Tasks</a>";
                    } 
                    ?>
                </li>
                <li>
                    <?php
                    //locations
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/recommendations.php\">Locations Recommendation</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/recommendations.php\">Locations Recommendation</a>";
                    } 
                    ?>
                </li>
                <li>
                    <?php
                    //notifications
                    if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                        echo "<a href=\"http://localhost/orbital/notifications.php\">Notifications</a>";
                    }
                    else{
                        echo "<a href=\"http://localhost:8080/orbital/notifications.php\">Notifications</a>";
                    } 
                    ?>
                </li>
            </ul>
        </li>
        <li>
            <?php
            //Profile
            if ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] =='443'){
                echo "<a href=\"http://localhost/orbital/profile.php\">Profile</a>";
            }
            else{
                echo "<a href=\"http://localhost:8080/orbital/profile.php\">Profile</a>";
            } 
            ?>
        </li>
        <li>
            <form method="post">
                <button type="submit" name="logout" class="logoutbutton">
                    <img src="img/logout.png" width="20px" height="20px" alt="logout">
                </button>
            <?php
                if(isset($_POST['logout'])){
                    session_destroy();
                    unset($_SESSION['NUSEmail']);
                    
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
            </form>
        </li>
    </ul>
    <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</nav>
<script src="js\app.js"></script>

<style>
a {
  text-decoration: none;
}


ul {
	list-style: none;
	margin: 0;
	padding-left: 0;
}

li {
	color: #fff;
	display: block;
	float: left;
	padding: 1rem;
	position: relative;
	text-decoration: none;
  transition-duration: 0.5s;
}
  
li a {
  color: #fff;
}

li:hover {
	background: #424240;
	cursor: pointer;
}

ul li ul {
	background: #5d4954;
	visibility: hidden;
    opacity: 0;
    min-width: 5rem;
	position: absolute;
    transition: all 0.5s ease;
    margin-top: 1rem;
	left: 0;
    display: none;
}

ul li:hover > ul,
ul li ul:hover {
  visibility: visible;
  opacity: 1;
  display: block;
}

ul li ul li {
  clear: both;
  width: 100%;
}
</style>
