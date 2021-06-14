
    <nav>
        <div class="logo">StudyLah</div>
        <ul class="nav-links">
            <li><a href="http://localhost:8080/orbital/searchusers.php">Search</a></li>
            <li><a href="http://localhost:8080/orbital/dashboard.php/">Home</a></li>
            <li><a href="http://localhost:8080/orbital/message.php">Chats</a></li>
            <li><a href="http://localhost:8080/orbital/profile.php">Profile</a></li>
            <li><a href="http://localhost:8080/orbital/logout.php">Logout</a></li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>
    <script src="..\js\app.js"></script>
    <!--<div>
        <div class="navbaricon1">StudyLah!</div>
        <div class="navbaricon2">
            <form method="post">
                <button type="submit" name="logout" id="logoutbutton">
                    <img src="img/logout.png" width="30px" height="30px" alt="logout">
                </button>
            </form>
        </div>-->
        <!--?php

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
        <div class="navbaricon2"><img src="img/user.png" width="30px" height="30px" alt="user"></div><!--changeable
        <div class="navbaricon2"><img src="img/bell.png" width="30px" height="30px" alt="bell"></div>
        <div class="navbaricon2"><img src="img/calendar.png" width="30px" height="30px" alt="schedule"></div>
        <div class="removefloat"></div><!--remove float
    </div>-->
