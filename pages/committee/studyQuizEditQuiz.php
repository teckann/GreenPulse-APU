<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study & Quiz Edit Quiz Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png"> -->
</head>
<body>
   <?php include ("header.php");?>
    
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

        <select class="question-status-dropdown">
                    <option>Question</option>
                    <option>Question 1</option>
                    <option>Question 2</option>
                    <option>Question 3</option>
                    <option>Question 4</option>
                    <option>Question 5</option>
                </select>

        <div class = "study-quiz-module-name-box">
            <div class = "study-quiz-title">Quiz Question</div>
            <input type="text" placeholder = "Enter quiz question" class="event-box">
        </div>

        <div class = "study-quiz-module-name-box">
            <div class = "study-quiz-title">Option 1</div>
            <input type="text" placeholder = "Enter option 1" class="event-box">
        </div>

        <div class = "study-quiz-module-name-box">
            <div class = "study-quiz-title">Option 2</div>
            <input type="text" placeholder = "Enter option 2" class="event-box">
        </div>

        <div class = "study-quiz-module-name-box">
            <div class = "study-quiz-title">Option 3</div>
            <input type="text" placeholder = "Enter option 3" class="event-box">
        </div>

        <div class = "study-quiz-module-name-box">
            <div class = "study-quiz-title">Option 4</div>
            <input type="text" placeholder = "Enter option 4" class="event-box">
        </div>

        <div class = "study-quiz-module-name-box">
            <div class = "study-quiz-title">Quiz Answer/div>
            <input type="text" placeholder = "Enter quiz answer" class="event-box">
        </div>

        <div class = "study-quiz-module-name-box">
            <div class = "study-quiz-title">Points Given</div>
            <input type="text" placeholder = "Enter points given" class="event-box">
        </div>

        <div class = "space"></div>



 <button class="btnCreateEvent" >
                        Save Changes
                    </button>






        </div>
    </section>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>