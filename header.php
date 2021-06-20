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
                echo "<a href=\"http://localhost/orbital/dashboard.php\">Home</a>";
            }
            else{
                echo "<a href=\"http://localhost:8080/orbital/dashboard.php\">Home</a>";
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
