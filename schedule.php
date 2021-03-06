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
<html> 
    <head>
        <link rel="icon" href="img\studylah_logo.jpg" type="image/jpg">
        <title>Calendar</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
        <link rel="stylesheet" href="css\schedule.css">
        <link rel="stylesheet" href="css\navbar.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
        <script>
            $(document).ready(function() { //add calendar plug in
                var calendar = $('#calendar').fullCalendar({
                    editable:true, //allow to drop and resize event
                    header:{ //buttons 
                        left:'prev,next today',
                        center:'title',
                        right:'month,agendaWeek,agendaDay'
                    },

                    events: 'load.php', //to load all the events that is available in this page
                    selectable:true, //highlight multiple dates 
                    selectHelper:true,
                    select: function(start, end, allDay){ //prompt to add new event
                        var title = prompt("Enter Event Title");
                        var venue = prompt("Enter Event Location\n ");
                        if(title){
                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss"); //store current date and time
                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                            $.ajax({
                                url:"insert.php",
                                type:"POST",
                                data:{title:title, venue:venue, start:start, end:end}, //sent data to server
                                success:function(){
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Event Added");
                                }
                            })
                        }
                    },

                    editable:true,
                    eventResize:function(event){
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                        var title = event.title;
                        var ScheduleID = event.ScheduleID;
                        $.ajax({
                            url:"update.php",
                            type:"POST",
                            data:{title:title, start:start, end:end, ScheduleID:ScheduleID},
                            success:function(){
                                calendar.fullCalendar('refetchEvents');
                                alert('Event Update');
                            }
                        })
                    },

                    eventDrop:function(event){
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                        var title = event.title;
                        var ScheduleID = event.ScheduleID;
                        $.ajax({
                            url:"update.php",
                            type:"POST",
                            data:{title:title, start:start, end:end, ScheduleID:ScheduleID},
                            success:function(){
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Updated");
                            }
                        });
                    },

                    eventClick:function(event){
                        if(confirm("Are you sure you want to remove it?")){
                            var ScheduleID = event.ScheduleID;
                            $.ajax({
                                url:"delete.php",
                                type:"POST",
                                data:{ScheduleID:ScheduleID},
                                success:function(){
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Event Removed");
                                }
                            })
                        }
                    },

                });
            });
   
        </script>
</head>
<style>
   .reco{
        margin-left:50px;
        margin-bottom:20px;
    }

    .reco a{
        color: #5d4954;
    }
</style>
<body>
    <!--navbar-->
    <?php include('header.php');?>

    <br/>
    <div class="reco">
        <a href="recommendations.php">See Location Recommendations</a>
    </div>
    <div class="container">
        <div id="calendar"></div> <!--add calendar plug-->
    </div>
    <br/>

    <div class="end">
        <button class="nav_contact" >Contact Us</button>
    </div>
</body>

</html>
