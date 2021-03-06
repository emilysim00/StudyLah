<?php
@ob_start();
session_start();
date_default_timezone_set('Asia/Singapore');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "utf-8" />
    <title>StudyLah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--add icon at the tool bar-->
    <link rel="icon" href="img\studylah_logo.jpg" type="image/jpg">
    <link rel="stylesheet" href="css\contact.css">
    <link rel="stylesheet" href="css\main_page.css">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body id="loadfadein"> 
    <nav>
        <div class="menu">
            <div class="logo"></div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">News</a></li>
                <li><button class="nav_contact" onclick="document.getElementById('id01').style.display='block'">Contact</button></li>
            </ul>
        </div>
    </nav>

    <div id="slideshow" class="img"></div>

    <div class="middle">
        <div class="title" style="font-family:'Catamaran';font-size: 65px;">StudyLah!</div>
            <div class="sub_title">Pure fun and more fun</div>
                <div class="buttons">
                    <a href='signup.php'><button>Log In</button></a>
                    <a href='signup.php'><button class="second">Sign Up</button></a>
                </div>
    </div>
    
    <div id="id01" class="modal">
      
        <form class="modal-content animate" action="/action_page.php" method="post">
          <div class="imgcontainer">
            <h2 class="avatar">Contact Us</h2>
          </div>
      
          <div class="container">
            <input type="text" name="StudentEmail" placeholder="User Email" required>
            <textarea name="Message" cols="150" rows="10" id="textareabox" placeholder="Tell Us About It" required></textarea>
            <button class="submit-btn" type="submit">Submit</button>
          </div>
      
          <div class="container" style="background-color: rgba(0,0,0,0.4);">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
          </div>
        </form>
      </div>
      
      <script>
      // Get the modal
      var modal = document.getElementById('id01');
      
      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
          }
      }
      </script>
</body>
</html>