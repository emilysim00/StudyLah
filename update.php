<?php
//update.php
    $connect = new PDO('mysql:host=localhost;dbname=orbital', 'root', '');

    if(isset($_POST["ScheduleID"]))
    {
        $query = "UPDATE schedule SET title=:title, start_event=:start_event, end_event=:end_event WHERE ScheduleID=:ScheduleID";
        $statement = $connect->prepare($query);
        $statement->execute(
        array(
        ':title'  => $_POST['title'],
        ':start_event' => $_POST['start'],
        ':end_event' => $_POST['end'],
        ':ScheduleID'   => $_POST['ScheduleID']
        )
        );
    }
?>
