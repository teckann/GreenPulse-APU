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

    <div id="pointHead">
    <div>
        <div><button href="profile.php" class="backPoint" id="backFromPoint"><i class="fa-solid fa-arrow-left"></i> Point</button>  </div>
    </div>

    </div>

    <div id="realPointBigContainer">
        <div id="realPointBar">


        <div class="pointDetails" id="realPointDetails">
            <p id="pointLabel">Current Green Point :</p>
            <!-- point Amount will be key in by js -->
            <h1 class="pointAmount"></h1>

            <hr id="realPointLine">
        </div>
    </div>


    <div id="totalPointBar">
        <div>
        <div id="totalPointBar-left" >
        

            <img src="../../src/avatars/U004_avatar.jpg" alt="Badge Picture" id="badgePic">


            
            <button href="editProfile.php" id="editBadgeImg"><i class="fa-solid fa-pen" id="chooseBadgeIcon"></i></button>


        </div>
        </div>

        <div id="totalPointDetails">
            <p id="badgeName"> Badge Name</p>
            <p id="totalPointLabel">Total Earned Green Point : </p>
            <p id="totalEarnedPoint">6666 GP </p>
            

        </div>
</div>
        <div id="realPointDown">
            
            <!-- arrange the progrees through the width of currentProgress div -->
            <div class="progressBar" id="pointProgressBar">
                <div class="currentProgress">

                </div>
            </div>

            <p id="realPointMilestone">Next Milestone : <span class="nextMilestone"></span></p>

            <a href="BadgeMilestone.php"  id="linkBadgeMilestone" >Badge and Milestone &nbsp  <i class="fa-solid fa-arrow-right"></i></a>

        </div>
    


    </div>
    <div id="pointFlowBtnContainer">
        <a href="earnedPoint" ><div class="pointFlowBtn">Points Earned</div></a>
        <a href="spentPoint" ><div class="pointFlowBtn">Points Spent</div></a>
    
    </div>


</body>
</html>