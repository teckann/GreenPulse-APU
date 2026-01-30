<?php

    include("../../conn.php");

    
    include("../../backend/sessionData.php");

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Profile</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .navBar #profileNav {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
        }

        .navBar #profileNav span {
            color: #000000;
            
            background-color: #ffffff3c; 
            
            border-radius: 0 0 22px 22px; 
            
        }

        .navBar #profileNav:hover {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
            border-radius: 0;
            transform: translateY(0px);

        }

        .navBar .profileNav:hover span {
            color: #000000; 
        }

    </style>
</head>
<body>
    <?php include("header.php") ?>

    
    <div class="pointBar" id="profilePB">
        <div>
        <div class="pointBar-left" id="profilePointBar-left">
        
            <?php 

                $userID = $_SESSION["userID"];
            
                $sql_profileDetails = "SELECT * FROM users WHERE user_id = '$userID';";

                $profileDetails = mysqli_fetch_assoc(mysqli_query($conn,$sql_profileDetails));

                echo '<img src="../../'.$profileDetails['avatar'].'" alt="User Profile" class="profilePic">'; 

            
            ?>

            
            <a href="editProfile.php" id="editProfileBtn"><i class="fa-solid fa-pen" id="editProfileIcon"></i></a>


        </div>
        </div>

        <div class="pointDetails">
            <p id="pointLabel">Current Green Point :</p>
            <h1 class="pointAmount"></h1>
            <hr id="pointLine">

            <!-- arrange the progrees through the width of currentProgress div -->
            <div class="progressBar">
                <div class="currentProgress">

                </div>
            </div>

            <p id="pointMilestone">Next Milestone : <span class="nextMilestone"></span></p>

            <a href="point.php"  class="viewPoint" >View Your Point <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
    <div class="profileActionContainer">

    <div class="profileAction" id="treeAction">
        <a href="myTree.php">
            <div class="profileCircleIcon">
                <i class="fa-solid fa-tree"></i>
            </div>

            <div class="profileActionText">
                My Tree
            </div>            
        </a>

    </div>

    <div class="profileAction" id="historyAction">
        <a href="history.php">
            <div class="profileCircleIcon">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>

            <div class="profileActionText">
                History
            </div>
        </a>
    </div>

    <div class="profileAction" id="securityAction">
        <a href="security.php">
            <div class="profileCircleIcon">
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="profileActionText">
                Acc Security
            </div>
        </a>
    </div>

    <div class="profileAction" id="aboutUsAction">
        <a href="aboutUs.php">
            <div class="profileCircleIcon">
                <i class="fa-solid fa-circle-info"></i>
            </div>

            <div class="profileActionText">
                About Us
            </div>
        </a>
    </div>

    </div>

    <div class="logOutSection">
    <form action="../../backend/logoutRedirect.php">
        <button type="submit" class="logOutBtn">Log Out</button>
    </form>
    </div>


</body>
</html>