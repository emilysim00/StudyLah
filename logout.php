<?php
  session_start();
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
?>