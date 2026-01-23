// volunteer home page

<?php
    include("eventBackend.php");

    include("../../conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <?php include("header.php") ?>

    <div id="banner">
    <p>some system message</p>

    </div>

    
    <div class="pointBar">
        <div class="pointBar-left">
            <img src="../../src/avatars/U004_avatar.jpg" alt="User Profile" class="profilePic">
        </div>
        

        <div class="pointDetails">
            <p id="pointLabel">Current Green Point :</p>
            <!-- point Amount will be key in by js -->
            <h1 class="pointAmount"></h1>
            <hr id="pointLine">

            <!-- arrange the progrees through the width of currentProgress div -->
            <div class="progressBar">
                <div class="currentProgress">

                </div>
            </div>

            <p id="pointMilestone">Next Milestone : <span class="nextMilestone"></span></p>

            <a href="point.php" class="viewPoint" >View Your Point <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="event">
        <h2 class="upcomingEvent">Upcoming Event</h2>

        <h3 class="upcomingDate">Today / 
            <?php 
                $today = date('l', strtotime('now'));
                
                $tomorrow = date('l', strtotime('tomorrow'));
                $tomorrowDate = date('Y-m-d', strtotime('tomorrow'));
                echo $today;
            ?>
        </h3>

        <div id="todayBoxContainer">
            <?php


                $sql_today_event = "SELECT * FROM events WHERE event_datetime >= CURRENT_DATE
                            AND event_datetime < CURRENT_DATE + INTERVAL 1 DAY";

                $event = mysqli_query($conn,$sql_today_event);

                addEventCard($event);

            ?>

        </div>

        <h3 class="upcomingDate">Tomorrow / 
            <?php
            echo $tomorrow;
            ?>
        </h3>
        <div id="tomorrowBoxContainer">
            <?php

                $sql_tomorrow_event = "SELECT * FROM events WHERE event_datetime >= CURRENT_DATE + INTERVAL 1 DAY
                            AND event_datetime < CURRENT_DATE + INTERVAL 2 DAY";

                $events = mysqli_query($conn,$sql_tomorrow_event);

                addEventCard($events);

                mysqli_close($conn);
            ?>
        </div>
    </div>

    <?php include("footer.php") ?>
</body>
</html>