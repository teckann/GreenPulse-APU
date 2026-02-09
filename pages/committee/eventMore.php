<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    if (!isset($_GET['event_id'])) {
        echo "<script>alert('No event selected!'); window.location.href='eventMain.php';</script>";
        exit;
    }
    
    $eventID = mysqli_real_escape_string($conn, $_GET['event_id']);
    $sql = "SELECT * FROM events WHERE event_id = '$eventID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) <= 0) {
        echo "<script>alert('Event not found!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $rows = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>More Event</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include ("header.php");?>

    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EVENT DETAILS</h1>
            <p>VIEW THE EVENT DETAILS AND IMPORTANT INFORMATION HERE.</p>
        </div>

        <div class="back-icon-hidden" onclick="window.location.href='eventCreate.php'">
            <i class="fas fa-arrow-left"></i>
        </div>


    </div>

    <section class="event-controls-event-main">
        <div class = "white-color-box">
            <div class = "details-upper">
                <h2 class = "event-name"><?php echo $rows['event_title']?></h2>
                
                    <div class="action-buttons">
                        <button class="btn-manage-attendees" onclick = "window.location.href = 'eventAttendance.php?event_id=<?php echo $rows['event_id'];?>'">
                            <i class="fas fa-users"></i> Attendance
                        </button>
                        <button class="btn-share-details" onclick = "window.location.href = 'eventFeedback.php?event_id=<?php echo $rows['event_id'];?>'">
                            <i class="fas fa-book"></i> Feedback
                        </button>
                    </div>
            </div>

           <div class="event-details-container">
                <div class="left-side-container">
                    <div class="left-side-info-box">
                        <div class="more-poster">
                            <img src="../../<?php echo $rows['event_poster']; ?>" alt="Event Poster">
                        </div>
                        <div class="info-row">
                            <span class="info-label">Event ID</span>
                            <span class="info-value"><?php echo $rows['event_id']; ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Date Created:</span>
                            <span class="info-value"><?php echo $rows['posted_date']; ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Capacity:</span>
                            <span class="info-value"><?php echo $rows['capacity']; ?> Participants</span>
                        </div>
                    </div>
                </div>

                <div class="right-side-container">
                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">DATE & TIME</span>
                            <span class="detail-value"><?php echo $rows['event_datetime']; ?> (<?php echo $rows['duration']; ?>)</span>
                        </div>
                    </div>

                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">LOCATION</span>
                            <span class="detail-value"><?php echo $rows['location']; ?></span>
                        </div>
                    </div>

                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">POINTS</span>
                            <span class="detail-value"><?php echo $rows['points_given']; ?></span>
                            <span class = "detail-subvalue">per attendees</span>
                        </div>
                    </div>


                    <div class="description-container">
                        <div class="detail-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="detail-content">
                            <span class="detail-label">EVENT DESCRIPTION</span>
                            <p class="description-text">
                            <?php echo $rows['event_description']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

    </section>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>