<?php
    include("eventBackend.php");

    include("../../conn.php");

    
    include("../../backend/sessionData.php");
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
    <style>
        .navBar #eventNav {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
        }

        .navBar #eventNav span {
            color: #000000;
            
            background-color: #ffffff3c; 
            
            border-radius: 0 0 22px 22px; 
            
        }

        .navBar #eventNav:hover {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
            border-radius: 0;
            transform: translateY(0px);

        }

        .navBar .eventNav:hover span {
            color: #000000; 
        }
    </style>
</head>
<body>
    <?php include("header.php") ?>

    <div class="eventHead" id="availableEventHead">
    <div>
        <div><a href="event.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i></a> Available Event</div>
    </div>

    
    <div class="searchBar" id="availableSearchBar">

            <input autocomplete="off" id="searchEvent" class="searchArea" type="text" name="search" placeholder="Search...">
            <button class="searchButton" id="searchEventBtn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

    </div>

    </div>



    <div class="event">

        <div id="availableEventBox" class="eventCardContainer">
            <?php
                $todayDate = date('Y-m-d');


                $sql_eventAvailable = "SELECT * FROM events 
                                WHERE event_datetime >= CURRENT_DATE ;";
                

                $event = mysqli_query($conn,$sql_eventAvailable);

                addEventCard($event);


            ?>
        </div>

    </div>

        
    <div class="reloadSpace">
        <i id="reloadIcon" class="fa-solid fa-rotate-right reload-icon"></i>     
    </div>

    <footer class="footerGeneral">
    <p>More events coming soon</p>
    </footer>



</body>
</html>