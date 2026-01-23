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

    <div class="event">
        <div class="eventLabel">
            My Event
            <a href="myEvent.php">view all <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div id="myEventBox">
            <?php
                $todayDate = date('Y-m-d');


                $sql_eventMy = "SELECT * FROM events 
                                    WHERE event_id IN (
                                        SELECT event_id 
                                        FROM attendance 
                                        WHERE user_id = 'U004'
                                    ) 
                                    AND event_datetime >= CURRENT_DATE;";
                

                $event = mysqli_query($conn,$sql_eventMy);

                addEventCard($event);


            ?>
        </div>

        <div class="eventLabel">
            Available Event
            <a href="availableEvent.php">view all <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div id="availableEventBox">
            <?php
                     
                $sql_eventAvailable = "SELECT * FROM events 
                                    WHERE event_datetime >= CURRENT_DATE
                                    LIMIT 5;";
                

                $events = mysqli_query($conn,$sql_eventAvailable);
                
                addEventCard($events);

                mysqli_close($conn);

            ?>
        </div>
    </div>

</body>
</html>