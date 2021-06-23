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
} ?>

<?php

//load.php
$connect = new PDO('mysql:host=localhost;dbname=orbital', 'root', '');

$useremail=$_SESSION['NUSEmail'];
$sqlgetuser="SELECT * FROM users WHERE NUSEmail='$useremail'";
$sqlgetuser_statement = $connect->prepare($sqlgetuser);
$sqlgetuser_statement->execute();
$usr = $sqlgetuser_statement->fetch();
$user_id = $usr["UserID"];

$data = array();

$query = "SELECT * FROM schedule WHERE UserID='$user_id' ORDER BY ScheduleID"; //only display user schedule

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'ScheduleID'   => $row["ScheduleID"],
  'title'   => $row["title"],
  'venue'   => $row["venue"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}

echo json_encode($data);

?>

