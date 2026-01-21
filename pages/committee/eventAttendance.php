<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Attendance</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EVENT ATTENDANCE</h1>
            <p>CREATE AND MANAGE GREEN INITIATIVE EVENTS.</p>
        </div>
  
        <div class="add-icon" onclick="window.location.href='eventMore.php'">
            <i class="fa-solid fa-pen"></i>
        </div>

    </div>

    <!-- !!! -->
    <section class="event-controls-event-main">
        <div class = "white-color-box">
            <span class = "title"> Attendance</span>

            
            <!-- HEREEEEEEEEEEEEE -->
             <div class = "attendance-row">
                <span class = "numbering">1</span>
                <span class = "tpnumber">TP084369</span>
                <span class = "name">Cynthia Tan Xin Ru</span>
                <span class = "date-time">21 January 2026</span>
             </div>

             <div class = "attendance-row">
                <span class = "numbering">2</span>
                <span class = "tpnumber">TP009878</span>
                <span class = "name">Gan Teck Ann</span>
                <span class = "date-time">26 February 2026</span>
             </div>

             <div class = "attendance-row">
                <span class = "numbering">3</span>
                <span class = "tpnumber">TP083433</span>
                <span class = "name">Goh Yang Ee</span>
                <span class = "date-time">9 March 2026</span>
             </div>

             <div class = "attendance-row">
                <span class = "numbering">4</span>
                <span class = "tpnumber">TP080862</span>
                <span class = "name">Lim Jin Ming</span>
                <span class = "date-time">11 December 2026</span>
             </div>

             <div class = "attendance-row">
                <span class = "numbering">5</span>
                <span class = "tpnumber">TP080837</span>
                <span class = "name">Jeremiah Lim Chen Kai</span>
                <span class = "date-time">28 July 2026</span>
             </div>



        </div>
    </section>

</body>
</html>