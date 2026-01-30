<?php
    include("../../conn.php");


    include("eventBackend.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Home Page</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        
        .navBar #indexNav {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
        }

        .navBar #indexNav span {
            color: #000000;
            
            background-color: #ffffff3c; 
            
            border-radius: 0 0 22px 22px; 
            
        }

        .navBar #indexNav:hover {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
            border-radius: 0;
            transform: translateY(0px);

        }

        .navBar #indexNav:hover span {
            color: #000000; 
        }

    </style>

</head>
<body>
    <?php include("header.php");
    
    $sql_system_message = "SELECT * FROM announcement ORDER BY announcement_datetime DESC LIMIT 1;";
    
    $systemMessage = mysqli_fetch_assoc(mysqli_query($conn,$sql_system_message));
    ?>

    <div id="banner">
    <p><?php echo$systemMessage["announcement_details"]; ?></p>

    </div>

    
    <div class="pointBar">
        <div class="pointBar-left">
            
            <?php 

            
                $sql_profileDetails = "SELECT * FROM users WHERE user_id = '$userID';";

                $profileDetails = mysqli_fetch_assoc(mysqli_query($conn,$sql_profileDetails));

                echo '<img src="../../'.$profileDetails['avatar'].'" alt="User Profile" class="profilePic">'; 

            
            ?>
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