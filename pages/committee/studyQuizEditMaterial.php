<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study & Quiz Edit Material Page</title>
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
            <a href="studyQuizMain.php">Study & Quiz</a>
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
    
    <!-- Upper Part -->
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>STUDY & QUIZ MANAGEMENT</h1>
            <p>MANAGE STUDY MATERIALS AND QUIZZES IN ONE PLACE.</p>

        </div>
    </div>

    <!--START-->

    <section class="event-controls-event-main">
        <div class = "white-color-box">

<div class = "study-quiz-module-name-box">
                <div class = "study-quiz-title">Module Name</div>
                <input type="text" placeholder = "Module Name" class="event-box">
            </div>

          <div class = "study-quiz-description-box">
                <div class = "study-quiz-title">Description</div>
                <textarea placeholder="Event Description" class="event-big-box" rows="5"></textarea>
            </div>

            <div class = "study-quiz-module-upload">
                <div class = "study-quiz-title">Study Video</div>
                <input type="file" class="event-big-box">
            </div>

            <div class = "study-quiz-module-upload">
                <div class = "study-quiz-title">Study Material</div>
                <input type="file" class="event-big-box">
            </div>

            <button class="btnCreateEvent" >
                        Save Changes
                    </button>

















        </div>
    </section>
</body>
</html>