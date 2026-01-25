<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

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
    <!-- <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png"> -->
</head>
<body>
    <nav class = "navigation-bar">
        <div class = "hamburger-menu">
            <button onclick = "toggleMenu()">
                <img src="../../src/committee/hamburgerMenu.svg" alt="Hamburger Menu">
            </button>
        </div>

        <div class = "logo" onclick = "window.location.href='index.php'">
            <img src="../../src/elements/logo_horizontal.png" alt="Logo">
        </div>

        <div class = "desktopMenu">
            <a href="index.php">Home</a>
            <a href="treeAdoption.php">Tree Adoption</a>
            <a href="merchandises.php">Merchandises</a>
            <a href="eventMain.php">Events</a>
            <a href="studyQuiz.php">Study & Quiz</a>
        </div>

        <div class = "profile">
            <img src="../../src/committee/profilePicture.jpg" alt="Profile Picture">
        </div>
    </nav>

    <div class = "banner">
        <marquee direction = "right" scrollamount = "10">
            <p>Join our upcoming Recycling Workshop on Dec 30! Learn, create, and make a difference for a greener tomorrow.</p>
        </marquee>
    </div>

    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">

            <h1>EVENT DETAILS</h1>
            <p>CREATE AND MANAGE GREEN INITIATIVE EVENTS.</p>
        </div>
  

    </div>

    <!-- Lower Part  -->
    <section class="event-controls-event-main">
        <div class = "white-color-box">
            <div class = "details-upper">
                <h2 class = "event-name"><?php echo $rows['event_title']?></h2>
                
                    <div class="action-buttons">
                        <button class="btn-manage-attendees" onclick = "window.location.href = 'eventAttendance.php'">
                            <i class="fas fa-users"></i> Attendance
                        </button>
                        <button class="btn-share-details" onclick = "window.location.href = 'eventFeedback.php'">
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
</body>
</html>