<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
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
            <a href="study&Quiz.php">Study & Quiz</a>
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

    <!-- !!! -->
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EVENT DETAILS</h1>
            <p>CREATE AND MANAGE GREEN INITIATIVE EVENTS.</p>
        </div>
  
        <div class="add-icon" onclick="window.location.href='eventMore.php'">
            <i class="fa-solid fa-pen"></i>
        </div>

    </div>

    <!-- Lower Part  -->
    <section class="event-controls-event-main">
        <div class = "white-color-box">
            <div class = "details-upper">
                <h2 class = "event-name">Event Name</h2>
                <!-- <span class = "event-id">Event ID</span> -->
                                    <!-- Action Buttons -->
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
                <!-- Left -->
                <div class="left-side-container">

                    <div class="left-side-info-box">

                        <div class="more-poster">
                            <img src="../../src/eventPosters/poster1.png" alt="Event Poster">
                        </div>
                        <div class="info-row">
                            <span class="info-label">Posted by:</span>
                            <span class="info-value">Alex Rivera</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Date Created:</span>
                            <span class="info-value">Oct 12, 2023</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status:</span>
                            <span class="status-badge active">
                                <span class="circle"></span> ACTIVE
                            </span>
                        </div>
                    </div>

                    
                    
                    
                </div>
                
                <!-- Right -->
                <div class="right-side-container">
                    <!-- Date & Time -->
                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">DATE & TIME</span>
                            <span class="detail-value">Saturday, May 15, 2024</span>
                            <span class="detail-subvalue">08:00 AM - 02:00 PM</span>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">LOCATION</span>
                            <span class="detail-value">Green Valley Reserve</span>
                            <span class="detail-subvalue">Sector 4, North Entrance</span>
                        </div>
                    </div>

                    <!-- Participation & Points -->
                    <div class="detail-box-row">
                        <div class="detail-box-small">
                            <div class="detail-content">
                                <span class="detail-label">PARTICIPATION</span>
                                <span class="detail-value">150</span>
                                <span class="detail-subvalue">Points per attendee</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="description-container">
                        <div class="detail-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="detail-content">
                            <span class="detail-label">EVENT DESCRIPTION</span>
                            <p class="description-text">
                                Join our community effort to restore the local biodiversity at Green Valley Reserve. 
                                We will be planting over 200 native saplings and clearing invasive species along the riverbank.
                               
                            
                            </p>
                        </div>
                    </div>
                </div>
        </div>
    </section>
</body>
</html>