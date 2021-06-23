<?php
//delete.php
    if(isset($_POST["ScheduleID"]))
    {
        $connect = new PDO('mysql:host=localhost;dbname=orbital', 'root', '');
        $query = "DELETE from schedule WHERE ScheduleID=:ScheduleID";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(':ScheduleID' => $_POST['ScheduleID'])
        );
    }
?>