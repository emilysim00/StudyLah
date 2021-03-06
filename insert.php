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

<?php
//insert.php

$connect = new PDO('mysql:host=localhost;dbname=orbital', 'root', '');

$useremail=$_SESSION['NUSEmail'];
$sqlgetuser="SELECT * FROM users WHERE NUSEmail='$useremail'";
$sqlgetuser_statement = $connect->prepare($sqlgetuser);
$sqlgetuser_statement->execute();
$usr = $sqlgetuser_statement->fetch();
$user_id = $usr["UserID"];

if(isset($_POST["title"]))
{
    $query = "INSERT INTO schedule (title, UserID, venue, start_event, end_event) VALUES (:title, '$user_id', :venue, :start_event, :end_event)";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':title'  => $_POST['title'],
            ':venue'  => $_POST['venue'],
            ':start_event' => $_POST['start'],
            ':end_event' => $_POST['end']
        )
    );
}

?>