<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    if (!isset($_GET['event_id'])) {
        echo "<script>alert('No event selected!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $eventID = mysqli_real_escape_string($conn,$_GET['event_id']);
    $sqlEventID = " SELECT * FROM events WHERE event_id = '$eventID'";
    $resultEventID = mysqli_query ($conn,$sqlEventID);

    if (mysqli_num_rows($resultEventID) <= 0) {
        echo "<script>alert('Event not found!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $eventData = mysqli_fetch_assoc($resultEventID); 

    $sql = "SELECT f.*, u.avatar, u.name
    FROM feedback f LEFT JOIN users u 
    ON f.user_id = u.user_id
    WHERE f.event_id = '$eventID' ORDER BY f.submit_datetime DESC";
    $result = mysqli_query($conn, $sql);

                    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Feedback Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
</head>
<body>

<?php include ("header.php");?>

    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EVENT FEEDBACK</h1>
            <p>VIEW ALL EVENT FEEDBACK HERE.</p>
        </div>
    </div>

    <section class="event-controls-event-main">
        <div class = "white-color-box">

            <span class = "title">Event Feedback</span>
            <?php
                if (mysqli_num_rows($result) <= 0) {
                    echo "<p>No feedback records for this event.</p>";
                }
                else {
                    while ($rows = mysqli_fetch_array($result)){
                ?>
            
                <div class="event-feedback-outer-box">
                    <div class="feedback-header">
                        <div class="avatar">
                            <?php if (!empty($rows['avatar'])): ?>
                                <img src="../../<?php echo $rows['avatar']; ?>" alt="User Avatar" >
                            <?php else: ?>
                                <i class="fa-solid fa-user"></i>
                            <?php endif; ?>
                        </div>
                        <div class="feedback-id-container">
                            <div class="feedback-id">
                                <span class="title-feedback">Feedback ID: <?php echo $rows['feedback_id']; ?></span>
                                <span class="title-feedback">Submitted by: <?php echo $rows['user_id']; ?></span>
                            </div>
                            <div class="date-time">
                                <span class="title-date"><?php echo $rows['submit_datetime']?></span>
                            </div>
                        </div>
                    </div>

                    <div class="event-feedback-inner-box">"<?php echo $rows['feedback_details']?>"</div>
                </div>
   
               <?php 
        } 
    } 
    ?>
        </div>
    </section>
   <?php include ("hamburgerMenu.php");?>
</body>
</html>